# Maya Digital Studio — PHP Admin Edition

This edition adds a real PHP admin panel backed by JSON files.

## Hosting requirement
Use PHP hosting (cPanel/shared hosting/VPS). GitHub Pages cannot run PHP.

## Admin
Open:
`/admin.php`

Default password:
`Admin@12345`

**Change the password hash in `config.php` before publishing.**

## Admin features
- Site settings: brand, email, phone, WhatsApp
- Add/edit/remove services
- Add/edit/remove portfolio projects
- Add/edit/remove blog posts
- View recent project inquiries
- Website reads the same data, so saved changes appear on PHP pages

## Contact
The contact form:
1. Saves the inquiry into `inquiries.json`
2. Opens WhatsApp with the full enquiry message

The current WhatsApp number is 01927679203.

## Important
JSON files must be writable by PHP. On most shared hosting this works automatically; if not, set appropriate file permissions.
