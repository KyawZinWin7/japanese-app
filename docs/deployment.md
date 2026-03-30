# Deployment Setup

This repository includes:

- `.github/workflows/ci.yml`
- `.github/workflows/deploy.yml`
- `ansible/playbooks/deploy.yml`
- `ansible/templates/nginx.conf.j2`
- `ansible/requirements.yml`

## GitHub Secrets

Add these repository or environment secrets before running production deploy:

- `PROD_HOST`
- `PROD_USER`
- `PROD_APP_DIR` (`/var/www/html/japanese-app`)
- `PROD_SSH_PRIVATE_KEY`
- `PROD_ENV_FILE`

## Production Inventory

Update `ansible/inventory/production.ini` with your real Lightsail host and deploy user.

Example:

```ini
[app]
production ansible_host=3.113.76.120 ansible_user=ubuntu
```

## Notes

- This deploy flow assumes `Ubuntu + Nginx + PHP 8.2 FPM` on Lightsail.
- Current server setup uses `ubuntu` as the SSH user.
- Recommended app path is `/var/www/html/japanese-app`.
- The Laravel app is configured to listen on port `8082` in the provided Nginx template.
- Use `APP_URL=http://3.113.76.120:8082` in `PROD_ENV_FILE` unless you later move to a domain/reverse proxy setup.
- After the instance is created and your SSH public key is already in `authorized_keys`, this setup can bootstrap the app server without manually logging in again.
- `PROD_ENV_FILE` should contain the full Laravel `.env` content.
- The provided Nginx config uses the deploy host/IP by default; replace it with your real domain after DNS is ready.
- This shared-server-safe deploy does not install or manage MySQL.
- Database creation and DB user creation should be handled separately on the server after MySQL is repaired.
- Migrations are skipped by default in this mode. Turn them on only after the database is healthy.
- If you use queues, add `supervisor` and a queue worker config as the next step.
- If you use the scheduler, add a cron entry for `php artisan schedule:run`.
