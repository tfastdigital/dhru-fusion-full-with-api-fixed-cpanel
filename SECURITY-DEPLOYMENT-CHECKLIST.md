# Dhru Fusion deployment security review

**Status:** review checklist only; no vulnerability has been confirmed by this document.

## Pre-deployment verification

- [ ] Identify active configuration files and verify that no production credentials, API tokens or customer data are committed (including Git history).
- [ ] Review SQL dumps for real user records, password hashes, keys, transaction records and personally identifiable information. Replace with synthetic fixtures where necessary.
- [ ] Remove or restrict both installer directories and database import/repair scripts after setup.
- [ ] Require authenticated, authorized access to cron and maintenance endpoints; avoid unauthenticated URL-triggered jobs.
- [ ] Verify API authentication, per-account authorization, request validation and rate limiting with tests.
- [ ] Confirm supplier API secrets are encrypted at rest and never included in client responses or logs.
- [ ] Restrict database privileges, uploads and writable directories; disable public directory listings.
- [ ] Enable CSRF protection for state-changing browser requests and secure cookie/session settings.
- [ ] Verify PHP/runtime compatibility, dependency security, backups, restore testing and audit logging.
- [ ] Review third-party distribution rights, original licensing and attribution before redistribution.

## Priority review paths

- `configs/`, `api/`, `includes/`, `admincp/`
- `installer/`, `installer_/`, `import_db.php`, `fix_missing_tables.php`
- `tfastdigital_dhru_s_db.sql`, `tfastdigital_Dhru10.sql`

Do not publish sensitive findings or secret values in a public issue or pull-request discussion. If any secret is exposed, revoke/rotate it and review history and logs before closing the incident.
