# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [unreleased]

### Changed

- Smtp mails are always flagged as "successful sent" if no error occours.
- A "sent_at" timestamp is added to mail entity on sending

### Added
- Smtp transport class
- System config values