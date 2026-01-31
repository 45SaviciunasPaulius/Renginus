# Renginus

## Introduction
Renginus is an internal event management platform designed for companies to plan, organize and manage a variety of events such as seminars, trainings, business trips, or informal outings. Built for use inside a single organization, Renginus replaces ad-hoc event workflows (email invitations, manual lists, chat announcements) with a single, simple solution tailored to the company's needs. The platform aims to simplify event organization, improve resource planning, encourage more frequent event creation, and help measure event interest over time.

## Project Goal
Create a functioning platform that enables companies to organize and manage internal events.

### Objectives
1. Build an event planning page.
2. Create a database to store application data.
3. Implement a responsive, modern design.
4. Deploy a working and functional event management platform.

## Key Features
- User roles and management
  - Administrator and regular user roles.
  - Administrators can approve/reject events and change user roles via an admin panel.
- Event creation and management
  - Create events with title, date, time, description, images, location, price and available seats.
  - Rich text editing for descriptions (Quill).
  - Map display for event locations (Google Maps API).
- Event registration
  - Users can register for events; available seats are decremented on registration.
- Filtering and search
  - Filter by event type and date range; search via text input.
- Save/Bookmark events
  - Users can bookmark events and view them on a "My Events" page.
- Past-event handling
  - Past events are shown as archived (grayed out), and registration is disabled.
- User profile management
  - Users can edit profile picture, name, password, and other personal settings.

## Technology Stack
- Frontend
  - HTML
  - CSS (Bootstrap)
  - JavaScript (including Quill for rich text)
- Backend
  - PHP
- Database
  - MariaDB (SQL)
- Development / Tools
  - XAMPP (local server stack)
  - VS Code (editor)
  - Google Maps API (location display)
  - Quill API (rich text editor)

## Database
Database name: `renginiu_db`

Main tables (relationships exist between these tables):
- `vartotojai` — stores registered users: first name, last name, email, hashed password, role, avatar.
- `renginys` — stores event information (title, date/time, description, location, price, total seats, etc.).
- `rezervacijos` — records user registrations for events and tracks remaining seats.
- `renginio_nuotraukos` — stores filenames of event images and associates them with events.
- `atsiliepimai` (not used in current version) — intended for storing reviews/comments for past events (schema exists but UI is not implemented).

## Project Structure (files / folders)
- `images/` — project images
- `connect.php` — database connection
- `index.php` — login form
- `Pagrindinis.php` — main page showing events
- `renginio_forma.php` — event creation form
- `renginys.php` — single-event display page
- `vartotojo_profilis.php` — user profile page (shows admin panel when user is admin)
- `keisti_role.php` — script for admin to change a user's role
- `tvarkyti_rengini.php` — admin actions to approve/reject submitted events
- `logout.php` — logout / end session
- `script.js` — JavaScript functions for UI behavior
- `style.css` — layout and style rules

## Installation (local)
1. Install XAMPP (or another local PHP + MySQL/MariaDB stack).
2. Place project files in your web server's document root (for XAMPP: `htdocs/<project-folder>`).
3. Start Apache and MariaDB via XAMPP control panel.
4. Create the database `renginiu_db` and import the project's SQL schema (if provided).
5. Update `connect.php` with your database credentials (host, username, password, db name).
6. Ensure API keys (e.g., Google Maps) are configured where applicable.
7. Open the site in a browser (e.g., `http://localhost/<project-folder>/index.php`) and register/login.

## Usage
- Regular users can browse events, search and filter, register for events, save/bookmark events, and edit their profile.
- Administrators can approve or reject event submissions, manage users and roles, and oversee event listings.

