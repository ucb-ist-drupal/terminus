# WPS-Specific Terminus Changelog

This changelog documents WPS-specific changes to the Terminus fork maintained for WpsConsole integration.

## wps-terminus-4.1.1-rev2 (2025-12-01)

### Changed
- **BREAKING**: Moved php-vcr/php-vcr from require-dev to require

### Rationale
This change ensures php-vcr is available in the compiled phar, which is necessary for:
1. **phpVCR functionality**: The phar must include php-vcr classes for WpsConsole's phpVCR testing integration
2. **Development workflow**: When mounting terminus source for debugging with xdebug (bin/wps -T), php-vcr must be available
3. **Build simplification**: Avoids complex Box configuration to force inclusion of dev dependencies in the phar

While php-vcr is technically a testing dependency, its small footprint and critical role in WPS development workflows justifies inclusion in production dependencies. This ensures consistent behavior whether terminus runs from the phar or mounted source.

## wps-terminus-4.1.1 (2025-11-28)

### Updated
- Merged upstream Terminus 4.1.1 into wps-terminus branch
- Updated dependencies to match Terminus 4.x requirements
- Added php-vcr/php-vcr ^1.8.0 to require-dev (for phpVCR integration)
- Removed obsolete "source" install preference for php-vcr (patches no longer needed)

### Maintained
- WPS_VCR_PATH patch preserved and verified in src/Terminus.php
- phpVCR integration continues to function for WpsConsole testing

### Notes
- Upstream Terminus 4.1.1 removed php-vcr from their dependencies
- WPS fork retains php-vcr to support WPS_VCR_PATH functionality
- php-vcr patches previously needed have been merged upstream as of version 1.5.2+

## wps-terminus-3.4.0 (Previous Release)

_Initial WPS fork based on Terminus 3.4.0 with phpVCR integration patches._
