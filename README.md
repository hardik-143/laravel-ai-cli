# Laravel AI CLI

AI-powered CLI tools for Laravel using the Laravel AI SDK. This package provides intelligent commands for asking questions, explaining errors, and reviewing code directly from your terminal.

## Features

- **Help Command** (`ai`) - Display comprehensive help information and all available commands
- **Ask Agent** (`ai:ask`) - Ask AI a question about your code or any topic
- **Explain Agent** (`ai:explain`) - Understand application errors and log files
- **Review Agent** (`ai:review`) - Get code reviews from an AI senior engineer
- **Optimize Agent** (`ai:optimize`) - Optimize code for performance and efficiency
- **Refactor Agent** (`ai:refactor`) - Refactor code for better quality and maintainability
- **Document Agent** (`ai:document`) - Generate comprehensive markdown documentation (display in terminal or save to file)
- **Image Generator** (`ai:image`) - Generate images from text descriptions with interactive quality and aspect ratio selection
- **Image Modifier** (`ai:imagemod`) - Modify and enhance existing images with AI-powered transformation

## Requirements

- PHP ^8.2
- Laravel ^12.0
- Laravel AI SDK ^0.1

## Installation

### 1. Add the Package to Your Laravel Project

```bash
composer require laravel-ai/cli
```

The package will be automatically discovered by Laravel via service provider auto-discovery.

### 2. Configure Your AI Provider

**Currently Supported:** OpenAI

Configure your OpenAI API key in your `.env` file:

```env
OPENAI_API_KEY=sk-proj-your-api-key-here
```

**Coming Soon:** More providers including Anthropic Claude, Google Gemini, and Cohere will be integrated in upcoming releases.

## Usage

### Get Help

Display comprehensive help information and all available commands:

```bash
php artisan ai
```

This will show package information, version details, and usage examples for all available commands.

### Ask a Question

Ask the AI assistant any question:

```bash
php artisan ai:ask "What are the best practices for Laravel security?"
```

### Explain an Error

Get a clear explanation of error messages or log files:

```bash
php artisan ai:explain /path/to/error-log.txt
```

Example:

```bash
php artisan ai:explain storage/logs/laravel.log
```

### Review Code

Get feedback on your code from an AI senior engineer:

```bash
php artisan ai:review /path/to/your/file.php
```

Example:

```bash
php artisan ai:review app/Models/User.php
```

### Generate Images

Generate AI images from text descriptions:

```bash
php artisan ai:image "A beautiful sunset over mountains"
```

The command will prompt you to select:

- **Quality**: high, medium, or low
- **Aspect Ratio**: square, portrait, or landscape
- **Count**: 1-4 images to generate

**Options:**

```bash
# Save to specific file
php artisan ai:image "A beautiful sunset" --output=output.png

# Save to specific directory
php artisan ai:image "A beautiful sunset" --dir=images

# Generate 3 images
php artisan ai:image "A beautiful sunset" --count=3

# Save metadata JSON with generation details
php artisan ai:image "A beautiful sunset" --metadata

# Custom timeout in seconds
php artisan ai:image "A beautiful sunset" --timeout=180
```

### Modify Images

Modify and enhance existing images:

```bash
php artisan ai:imagemod /path/to/image.png "Make it brighter and more vibrant"
```

The command will prompt you to select:

- **Quality**: high, medium, or low
- **Aspect Ratio**: square, portrait, landscape, or keep-original
- **Count**: 1-4 variations to generate

**Options:**

```bash
# Save to specific file
php artisan ai:imagemod image.png "Make it brighter" --output=brightened.png

# Save to specific directory
php artisan ai:imagemod image.png "Make it brighter" --dir=modified

# Generate 2 variations
php artisan ai:imagemod image.png "Make it brighter" --count=2

# Save metadata JSON with modification details
php artisan ai:imagemod image.png "Make it brighter" --metadata

# Custom timeout in seconds
php artisan ai:imagemod image.png "Make it brighter" --timeout=180
```

## Command Details

### ai:ask

```bash
php artisan ai:ask {prompt}
```

**Arguments:**

- `prompt` - Your question for the AI

**Example:**

```bash
php artisan ai:ask "How do I implement dependency injection in Laravel?"
```

---

### ai:explain

```bash
php artisan ai:explain {file}
```

**Arguments:**

- `file` - Path to the error or log file to explain

**Example:**

```bash
php artisan ai:explain storage/logs/laravel.log
```

---

### ai:optimize

```bash
php artisan ai:optimize {file}
```

**Arguments:**

- `file` - Path to the source code file to optimize

**Example:**

```bash
php artisan ai:optimize app/Models/User.php
```

---

### ai:refactor

```bash
php artisan ai:refactor {file}
```

**Arguments:**

- `file` - Path to the source code file to refactor

**Example:**

```bash
php artisan ai:refactor app/Http/Controllers/ProductController.php
```

---

### ai:document

```bash
php artisan ai:document {file}
```

Generates comprehensive markdown documentation. The command will prompt you to choose how to receive the documentation:

**Arguments:**

- `file` - Path to the source code file to document

**Output Options:**

1. **Display in Terminal** - View formatted markdown directly in your terminal
2. **Save to File** - Save as `DOCUMENTATION_{filename}.md` in project root

**Example:**

```bash
php artisan ai:document app/Services/PaymentService.php

How would you like to receive the documentation?:
  [0] Display in terminal
  [1] Save to file (DOCUMENTATION_PaymentService.md)
 > 1
```

The generated documentation includes:

- Detailed overview and purpose
- PHPDoc style comments
- Parameter documentation
- Usage examples with code blocks
- Important notes and edge cases
- Related files references

---

### ai:image

```bash
php artisan ai:image {prompt} {options}
```

Generates AI-powered images from text descriptions.

**Arguments:**

- `prompt` - Description or prompt for the image to generate

**Options:**

- `--output=PATH` - Save to a specific file path
- `--dir=PATH` - Save to a specific directory (defaults to project root)
- `--count=N` - Generate 1-4 images at once (default: 1)
- `--timeout=N` - HTTP timeout in seconds (default: 120)
- `--metadata` - Save generation metadata to JSON file

**Example:**

```bash
php artisan ai:image "A serene mountain landscape at sunset"

Select image quality:
  [0] high
  [1] medium
  [2] low
 > 0

Select aspect ratio:
  [0] square
  [1] portrait
  [2] landscape
 > 2

✓ Successfully generated image!
1. /Users/hardik/laravel-php/laravel-ai-cli/IMAGE_2026-02-07_15-30-45_1.png
📋 Metadata saved to: /Users/hardik/laravel-php/laravel-ai-cli/metadata_2026-02-07_15-30-45.json
```

**Batch Generation:**

```bash
# Generate 3 images at once
php artisan ai:image "A futuristic city" --count=3 --metadata
```

---

### ai:imagemod

```bash
php artisan ai:imagemod {image} {modification} {options}
```

Modifies and enhances existing images using AI.

**Arguments:**

- `image` - Path to the image file to modify
- `modification` - Description of modifications to apply

**Options:**

- `--output=PATH` - Save to a specific file path
- `--dir=PATH` - Save to a specific directory (defaults to project root)
- `--count=N` - Generate 1-4 variations (default: 1)
- `--timeout=N` - HTTP timeout in seconds (default: 120)
- `--metadata` - Save modification metadata to JSON file

**Supported Image Formats:**

- JPEG (.jpg, .jpeg)
- PNG (.png)
- GIF (.gif)
- WebP (.webp)
- SVG (.svg)

**Example:**

```bash
php artisan ai:imagemod image.png "Make it more vibrant and increase contrast"

Select image quality:
  [0] high
  [1] medium
  [2] low
 > 0

Select aspect ratio:
  [0] square
  [1] portrait
  [2] landscape
  [3] keep-original
 > 3

✓ Successfully generated image modification!
1. /Users/hardik/laravel-php/laravel-ai-cli/IMAGE_MOD_2026-02-07_15-31-22_1.png
📋 Metadata saved to: /Users/hardik/laravel-php/laravel-ai-cli/metadata_2026-02-07_15-31-22.json
```

**Multiple Variations:**

```bash
# Create 2 variations of the modified image
php artisan ai:imagemod image.png "Make it brighter" --count=2 --metadata
```

## Package Structure

```
src/
├── AiCliServiceProvider.php            # Service provider (auto-discovered)
├── Commands/
│   ├── AskCommand.php                  # Ask question command
│   ├── DocumentCommand.php             # Generate documentation command
│   ├── DocumentMarkdownCommand.php     # Generate markdown documentation & save to file
│   ├── ExplainCommand.php              # Explain errors command
│   ├── OptimizeCommand.php             # Optimize code command
│   ├── RefactorCommand.php             # Refactor code command
│   └── ReviewCommand.php               # Code review command
└── Ai/
    └── Agents/
        ├── AskAgent.php                # AI agent for questions
        ├── DocumentAgent.php           # AI agent for documentation (plain text)
        ├── ExplainAgent.php            # AI agent for explanations
        ├── MarkdownDocumentAgent.php   # AI agent for markdown documentation
        ├── OptimizeAgent.php           # AI agent for optimization
        ├── RefactorAgent.php           # AI agent for refactoring
        └── ReviewAgent.php             # AI agent for code reviews
```

## How It Works

1. **Service Provider** - Auto-loads commands on Laravel startup
2. **Commands** - Handle CLI input and file reading
3. **Agents** - Implement the AI logic with specific instructions for each task
4. **Laravel AI SDK** - Handles communication with the AI provider

Each agent uses the `Promptable` trait and implements the `Agent` interface, providing specific instructions to the AI for better results.

## Configuration

The package respects your Laravel AI configuration. You can customize behavior by:

1. Setting environment variables for your AI provider
2. Modifying agent instructions in the respective Agent classes

## Troubleshooting

### "File not found" Error

Ensure the file path is correct and relative to your Laravel project root:

```bash
# Correct - relative to project root
php artisan ai:explain storage/logs/laravel.log

# Correct - absolute path
php artisan ai:explain /full/path/to/file.log
```

### "Undefined type" IDE Errors

Run the following to regenerate autoloader files:

```bash
composer dump-autoload
```

### AI Response is Empty

1. Verify your API key is set in `.env`
2. Check your API quota/credits
3. Ensure the file exists and is readable

## License

MIT License. See LICENSE file for details.

## Support

For issues or feature requests, please open an issue on the repository.
