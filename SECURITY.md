# Security policy and server checklist: Dhru Fusion panel

Last reviewed: 23 Oct 2026.

## Reporting a vulnerability
Email info@tfastdigital.com (subject "Security"). Do not open a public issue.

## 1. PHP2Shell (CVE-2026-109618 / CVE-2026-109619): critical, unauthenticated RCE
This is a bug in **PHP itself**, not in this code. Only a patched PHP fixes it.
- Required server PHP: **PHP 8.3.36+ (or 8.2.35+ / 8.4.27+ / 8.5.12+), subject to the ionCube/loader version the panel needs**. In Hostinger hPanel > Advanced > PHP Configuration pick that version,
  then check the PHP Info "Build Date" is 21 Oct 2026 or later.
- Defence-in-depth shipped in this repo (reduces exposure, is NOT a fix):
  - `.user.ini`: `session.upload_progress.enabled = 0`, strict sessions, HttpOnly cookies, `display_errors = Off`.
  - `.htaccess`: security headers, `X-Powered-By` removed, secrets/dumps/VCS files denied.
  - Upload/image folders refuse to run scripts.
- `expose_php` is a server-level setting: set it Off in hPanel > PHP Options.
- Check access logs from 17 Oct 2026 onwards for odd `POST` requests carrying `PHP_SESSION_UPLOAD_PROGRESS`,
  and look for new/unknown `.php` files in upload, image and cache folders.

## 2. laravel-lang supply-chain compromise (May 2026)
- This project has no root Composer project (only bundled 3rd-party libs), so it cannot pull `laravel-lang/*`. Checked 23 Oct 2026: no `flipboxstudio` IOC in the repo.
- CI (`.github/workflows/security.yml`) greps for the IOC string `flipboxstudio` on every push/PR and weekly.

## 3. Server checklist
- [ ] PHP version patched (see section 1) and `expose_php = Off`.
- [ ] Debug output off in production (`APP_DEBUG=false` for Laravel apps).
- [ ] Daily backups of files + database; take a manual backup before every deploy/merge.
- [ ] Rotate any key/password that was ever committed, pasted into chat or a ticket.
- [ ] Run the host's malware scanner once after patching PHP.


## 4. Hard-coded database credentials in this PUBLIC repo (found 23 Oct 2026)
The same DB username/password/name is hard-coded in about 39 PHP files, including `comm.php`, `fix_missing_tables.php`,
`import_db.php` and many `admincp/includes/pages/*.php`. Because this repository is public, treat that password as leaked:
1. Change the MySQL user's password in hPanel now (use a long random one, not the username).
2. Make the code read it from one non-committed config file instead of literals.
3. Consider making this repository private. This PR does not rewrite history; the old value stays in git history.
- `fix_missing_tables.php`, `import_db.php` and `installer_/` are now denied over HTTP; delete them from the server if not needed.
- Upload/download folders: `images/`, `download/` and `configs/` already ship deny rules.
