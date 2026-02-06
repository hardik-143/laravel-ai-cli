# Changelog

All notable changes to the Laravel AI CLI package will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-02-06

### Added

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

### Security

- Path traversal prevention in all file-based commands
- File readability checks before processing
- Input validation and sanitization
- Comprehensive exception handling

## [Unreleased]

### Planned Features

- Additional code analysis commands
- Configuration file support
- Output formatting options
- Batch processing capabilities
- Integration with CI/CD pipelines
