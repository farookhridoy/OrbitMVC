<?php

namespace OrbitMVC\View;

class Compiler {
    protected array $sections = [];
    protected ?string $layout = null;

    public function compile(string $content): string {
        // 1. Core Syntax: Variables
        $content = preg_replace('/\{\{\s*(.+?)\s*\}\}/', '<?php echo htmlspecialchars($1); ?>', $content);
        $content = preg_replace('/\{\{\{\s*(.+?)\s*\}\}\}/', '<?php echo $1; ?>', $content);

        // 2. Control Structures: If/Else
        $content = preg_replace('/@if\s*\((.+?)\)/', '<?php if($1): ?>', $content);
        $content = preg_replace('/@elseif\s*\((.+?)\)/', '<?php elseif($1): ?>', $content);
        $content = preg_replace('/@else/', '<?php else: ?>', $content);
        $content = preg_replace('/@endif/', '<?php endif; ?>', $content);

        // 3. Control Structures: Foreach
        $content = preg_replace('/@foreach\s*\((.+?)\)/', '<?php foreach($1): ?>', $content);
        $content = preg_replace('/@endforeach/', '<?php endforeach; ?>', $content);

        // 4. Inheritance: Sections and Yields
        $content = $this->handleInheritance($content);

        return $content;
    }

    protected function handleInheritance(string $content): string {
        // Capture sections
        preg_match_all('/@section\([\'"](.*?)[\'"]\)(.*?)@endsection/s', $content, $matches);
        foreach ($matches[1] as $index => $name) {
            $this->sections[$name] = trim($matches[2][$index]);
        }

        // Remove section blocks from the content
        $content = preg_replace('/@section\([\'"](.*?)[\'"]\)(.*?)@endsection/s', '', $content);

        // Check for @extends
        if (preg_match('/@extends\([\'"](.*?)[\'"]\)/', $content, $match)) {
            $this->layout = $match[1];
            // Remove the @extends directive
            $content = preg_replace('/@extends\([\'"](.*?)[\'"]\)/', '', $content);
            
            // Generate the code to load the layout and inject sections
            // We return a instruction that the Engine will use
            return "LAYOUT:{$this->layout}|CONTENT:" . base64_encode($content);
        }

        // Handle @yield for layouts
        $content = preg_replace_callback('/@yield\([\'"](.*?)[\'"]\)/', function($m) {
            return $this->sections[$m[1]] ?? '';
        }, $content);

        return $content;
    }
}
