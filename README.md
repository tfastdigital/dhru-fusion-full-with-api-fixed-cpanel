# Dhru Fusion Full with API and cPanel Support

This repository contains a full Dhru Fusion deployment package with API gateway support, cPanel-friendly cron automation, admin control panel features, supplier portal functions, and installation utilities.

## Project Overview

Dhru Fusion is a PHP-based business automation and reseller platform for mobile service providers, digital retailers, and API-driven order processing systems.

This package includes:

- Full admin control panel in `admincp/`
- Client and supplier portals
- API entry points and modules in `api/`, `includes/api/`, `includes/apiclient/`, and `includes/apipos/`
- Server and service integration modules in `modules/apiserver/`
- Cron automation setup pages and cPanel guidance
- Installer support in `installer/` and legacy installer compatibility in `installer_/`
- Database schema dumps in `tfastdigital_dhru_s_db.sql` and `tfastdigital_Dhru10.sql`

## Key Features

### API and Integration

- Central dispatcher at `api/index.php`
- API authentication with username, API key, optional IP whitelist, and rate limiting
- JSON and XML response formats with versioning
- Built-in API actions for account info, service lists, orders, IMEI lookups, provider searches, and vouchers
- API module support for file services, mobile services, terminal registration, reward statements, and more
- API sync and order automation in `includes/apiserver.fun.php`, `includes/cron.php`, and `includes/cron2.php`
- API helper logic in `includes/api.fun.php`

### Admin Control Panel

- Comprehensive admin interface under `admincp/`
- Support ticket management, user and supplier administration, reports, and settings
- API settings, sync history, and cron configuration pages
- White-label, login security, and Google Authenticator support
- Built-in help links and wiki integration for Dhru Fusion setup

### Supplier and Client Management

- Supplier portal in `SupplierPanel/`
- Service provider integrations and gateway configuration
- Automated supplier pricing sync and order submission
- Support for IMEI and file service workflows

### Installer and Deployment

- Web installer available in `installer/`
- Legacy installer compatibility in `installer_/`
- SQL import assist scripts and installation helpers
- Secure deployment recommendations in `comm.php`

### cPanel and Cron Automation

- Built-in cron setup guidance in `admincp/includes/pages/cronsetting.php`
- Automation instructions for cPanel and remote scheduler services
- Commands for reminders, price changes, invoices, security checks, supplier sync, and general automation
- POP import support via `includes/pop.php`

## Installation Notes

1. Upload the project files to your web server.
2. Create a MySQL database and user.
3. Configure `configs/config.php` with your database credentials and site settings.
4. Run the installer from `installer/` and complete admin setup.
5. Remove the `installer/` directory after installation for security.
6. Configure cron jobs via the admin automation pages or cPanel.

## Recommended Cron Commands

Use commands similar to the following examples:

```bash
/usr/bin/wget -O - -q -t 1 https://YOUR_DOMAIN/includes/cron2.php
/usr/bin/wget -O - -q -t 1 https://YOUR_DOMAIN/includes/cron2.php?action=pricechange
/usr/bin/wget -O - -q -t 1 https://YOUR_DOMAIN/includes/cron2.php?action=invoice
/usr/bin/wget -O - -q -t 1 https://YOUR_DOMAIN/includes/cron2.php?action=security
/usr/bin/wget -O - -q -t 1 https://YOUR_DOMAIN/includes/cron2.php?action=newservice
```

## Security Notes

- Sensitive files such as `configs/config.php` are excluded via `.gitignore`.
- Remove `installer/` after setup.
- Review `admincp/index.php` and `comm.php` for deployment and security warnings.

## Excluded Files

The repository ignores local configuration files, logs, compiled templates, and SQL dumps to avoid accidental exposure of credentials or private data.

## License

The original Dhru Fusion codebase is proprietary. This repository contains the provided package and README documentation for deployment.

