<?php

namespace OrbitMVC\View;

class Engine {
    protected string $viewPath;
    protected string $cachePath;
    protected Compiler $compiler;

    public function __construct(string $viewPath, string $cachePath) {
        $this->viewPath = rtrim($viewPath, '/');
        $this->cachePath = rtrim($cachePath, '/');
        $this->compiler = new Compiler();
    }

    public function render(string $view, array $data = []): string {
        $viewFile = "{$this->viewPath}/" . str_replace('.', '/', $view) . ".blade.php";
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View [{$view}] not found at {$viewFile}");
        }

        $cacheFile = "{$this->cachePath}/" . str_replace('.', '_', $view) . ".php";

        // Simple compilation cache: only re-compile if view file changed
        if (!file_exists($cacheFile) || filemtime($viewFile) > filemtime($cacheFile)) {
            $this->compile($viewFile, $cacheFile);
        }

        extract($data);
        ob_start();
        include $cacheFile;
        $output = ob_get_clean();

        // Check for inheritance (LAYOUT instruction from compiler)
        if (str_starts_with($output, 'LAYOUT:')) {
            [$layoutInfo, $childContentEncoded] = explode('|CONTENT:', $output);
            $layoutName = str_replace('LAYOUT:', '', $layoutInfo);
            $childContent = base64_decode($childContentEncoded);

            // Re-render with layout context
            // In a better version, we'd pass the sections to the layout
            return $this->render($layoutName, array_merge($data, ['content' => $childContent]));
        }

        return $output;
    }

    protected function compile(string $viewFile, string $cacheFile) {
        $content = file_get_contents($viewFile);
        $compiled = $this->compiler->compile($content);
        
        if (!is_dir(dirname($cacheFile))) {
            mkdir(dirname($cacheFile), 0755, true);
        }
        
        file_put_contents($cacheFile, $compiled);
    }
}
