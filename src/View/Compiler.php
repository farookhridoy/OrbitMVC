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
        // Capture multi-line sections
        preg_match_all('/@section\([\'"]([^\'\"]*)[\'\"]\)(.*?)@endsection/s', $content, $matches);
        foreach ($matches[1] as $index => $name) {
            $this->sections[$name] = trim($matches[2][$index]);
        }

        // Capture single-line sections e.g. @section('title', 'My Title')
        preg_match_all('/@section\([\'"]([^\'\"]*)[\'\"]\s*,\s*(.*?)\)/', $content, $matches_single);
        foreach ($matches_single[1] as $index => $name) {
            $val = trim($matches_single[2][$index]);
            if (preg_match('/^[\'"](.*)[\'"]$/', $val, $vMatch)) {
                $val = $vMatch[1];
            }
            $this->sections[$name] = $val;
        }

        // Remove multi-line section blocks from the content
        $content = preg_replace('/@section\([\'"]([^\'\"]*)[\'\"]\)(.*?)@endsection/s', '', $content);
        // Remove single-line section blocks
        $content = preg_replace('/@section\([\'"]([^\'\"]*)[\'\"]\s*,\s*(.*?)\)/', '', $content);

        // Check for @extends
        if (preg_match('/@extends\([\'"](.*?)[\'\"]\)/', $content, $match)) {
            $this->layout = $match[1];
            $content = preg_replace('/@extends\([\'"](.*?)[\'\"]\)/', '', $content);

            // Pass sections + content to the Engine via a structured marker
            return "LAYOUT:{$this->layout}|SECTIONS:" . base64_encode(serialize($this->sections)) . "|CONTENT:" . base64_encode($content);
        }

        // Handle @yield for layouts - eval allows PHP code inside sections to execute
        $content = preg_replace('/@yield\([\'"](.*?)[\'"]\)/', '<?php $__name="$1"; $__val = $sections[$__name] ?? ($$__name ?? ""); eval("?> " . $__val); ?>', $content);

        return $content;
    }
}
