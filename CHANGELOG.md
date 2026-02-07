# Changelog

All notable changes to the Laravel AI CLI package will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.2] - 2026-02-07

### Added

- **`ai:image`** - Generate images from text descriptions using AI
- **`ai:imagemod`** - Modify and enhance existing images with AI
- Interactive quality selection (high, medium, low) for image commands
- Interactive aspect ratio selection (square, portrait, landscape) for generated images
- Batch image generation (1-4 images per command with `--count` option)
- Custom output file paths with `--output` option
- Custom output directories with `--dir` option
- Optional metadata JSON logging with `--metadata` flag to track generation details
- Progress bar display during image generation
- Automatic unique variation IDs to ensure diverse results on repeated prompts
- Full Laravel AI SDK integration for image generation and modification

### Features

- Interactive prompts for image quality and aspect ratio
- Batch processing up to 4 images in a single command
- File path customization (output file or directory)
- Optional metadata tracking (timestamp, settings, generated files)
- Automatic filename generation with timestamps
- File validation for image modification (JPEG, PNG, GIF, WebP, SVG)
- Comprehensive error handling and user feedback

## [1.0.1] - 2026-02-06

#### Commands

- **`ai:ask`** - Ask AI a question about your code or any topic
- **`ai:explain`** - Understand application errors and log files
- **`ai:review`** - Get code reviews from an AI senior engineer
- **`ai:optimize`** - Optimize code for performance and efficiency
- **`ai:refactor`** - Refactor code for better quality and maintainability
- **`ai:document`** - Generate comprehensive markdown documentation (interactive: display in terminal or save to file)

#### Agents

- **AskAgent** - Answers developer questions clearly and concisely
- **ExplainAgent** - Explains application errors and log files in simple terms
- **ReviewAgent** - Provides senior engineer code reviews
- **OptimizeAgent** - Identifies performance bottlenecks and optimization opportunities
- **RefactorAgent** - Suggests code improvements and design patterns
- **DocumentAgent** - Generates plain text documentation
- **MarkdownDocumentAgent** - Generates comprehensive markdown documentation

#### Features

- Service provider auto-discovery
- File path validation to prevent directory traversal attacks
- Comprehensive error handling and validation
- Exit code returns (SUCCESS/FAILURE)
- Plain text output with markdown only for lists (except document command)
- Interactive documentation command (choose between terminal display or file save)
- Input validation for all commands
- OpenAI API integration (currently supported provider)
- Detailed API configuration guide

### Providers

- **OpenAI** ✅ - Fully supported and tested

### Security

- Path traversal prevention in all file-based commands
- File readability checks before processing
- Input validation and sanitization
- Comprehensive exception handling

## [Unreleased]

### Planned Features

- **Additional AI Providers** (v1.1 - v2.0):
  - Anthropic Claude (v1.1)
  - Google Gemini (v1.2)
  - Cohere (v1.3)
  - Local LLMs (v2.0)
- Configuration file support (.airc)
- Output formatting options (JSON, XML, etc.)
- Batch processing capabilities
- CI/CD pipeline integration
- Command aliases and shortcuts
- Custom agent creation support
