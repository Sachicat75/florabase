🌿 Florabase --- Product Requirements Document (PRD)

Version: 1.0

Author: Paul

Tech Stack: Laravel 12, Livewire v3 (SPA), TailwindCSS, Flowbite UI, Laravel Fortify

Storage: Local filesystem

DB: Single database with user-level isolation

✅ 1. Product Overview

Florabase is a botanical collection management application that enables users to log, organize, and track:

Plants

Seeds

Propagations

Botanical taxonomy (Family → Subfamily → Genus)

Vendors

Locations

The app uses:

Livewire v3 for SPA-like navigation

Flowbite UI components

TailwindCSS + dark mode

Fortify for account management

All user data is isolated by user_id in a single shared database.

This document defines all requirements for Florabase v1.

✅ 2. Goals & Non-Goals

✅ Goals

Allow users to fully manage their plant, seed, and propagation collections.

Allow users to build their own taxonomy.

Provide CRUD interfaces for all modules.

Implement image uploads for plants and seeds.

Provide a dashboard with collection statistics.

Deliver a dark-mode, SPA-like experience.

Use Livewire + Flowbite UI components.

❌ Non-Goals (v1)

No AI or image recognition.

No public profiles or sharing.

No subscription billing (future).

No multi-database tenancy.

No calendar/reminder system (future).

✅ 3. User Roles

Role  Capabilities

User  Full access to CRUD for all personal data. Data isolated via user_id.

Admin (future)  Multi-tenant controls, subscription management.

Current version only supports User roles.

✅ 4. System Architecture

Laravel 12

Livewire v3 (SPA using wire:navigate)

Laravel Fortify (authentication & security)

TailwindCSS for styling

Flowbite for UI components

Flowbite dark mode for theme switching

Local filesystem for image storage

Single shared DB, data separated via user_id

Layout

Header (with dark mode toggle + user menu)

Left sidebar

Main content area

Fully responsive

✅ 5. Database Schema (Final)

5.1 Taxonomy Tables

families

id

user_id

name

common_name (nullable)

description (nullable)

image (nullable)

timestamps

subfamilies

id

user_id

family_id

name

description (nullable)

image (nullable)

timestamps

genera

id

user_id

subfamily_id

name

description (nullable)

image (nullable)

timestamps

5.2 Plant Tables

plants

id

user_id

genus_id

vendor_id (nullable)

location_id (nullable)

common_name

species (nullable)

purchase_price (decimal, nullable)

acquired_at (nullable)

light_level (enum: low/medium/bright, nullable)

water_frequency (integer, nullable)

last_watered_at (nullable)

notes (nullable)

timestamps

plant_photos

id

user_id

plant_id

path

caption (nullable)

order (nullable)

timestamps

5.3 Propagation Tables

propagations

id

user_id

plant_id

location_id (nullable)

method

status

start_date (nullable)

rooted_date (nullable)

germination_temperature (nullable)

notes (nullable)

timestamps

5.4 Management Tables

vendors

id

user_id

name

location (nullable)

website (nullable)

notes (nullable)

timestamps

locations

id

user_id

name

description (nullable)

timestamps

5.5 Seed Tables

seeds

id

user_id

vendor_id (nullable)

location_id (nullable)

name

scientific_name (nullable)

quantity (nullable)

purchase_price (nullable)

purchased_at (nullable)

sow_by (nullable)

germination_media (nullable)

start_date (nullable)

date_germinated (nullable)

germination_temperature (nullable)

notes (nullable)

timestamps

seed_photos

id

user_id

seed_id

path

caption (nullable)

order (nullable)

timestamps

✅ 6. Models & Relationships

Global rules:

Every model has user_id

Every model uses $fillable

Every image field has a getImageUrlAttribute() accessor

All queries scoped to authenticated user

Relationships Summary

Model  Relationships

Family  hasMany(Subfamily)

Subfamily  belongsTo(Family), hasMany(Genus)

Genus  belongsTo(Subfamily), hasMany(Plant)

Plant  belongsTo(Genus), belongsTo(Vendor), belongsTo(Location), hasMany(PlantPhoto), hasMany(Propagation)

PlantPhoto  belongsTo(Plant)

Propagation  belongsTo(Plant), belongsTo(Location)

Vendor  hasMany(Plant), hasMany(Seed)

Location  hasMany(Plant), hasMany(Propagation), hasMany(Seed)

Seed  belongsTo(Vendor), belongsTo(Location), hasMany(SeedPhoto)

SeedPhoto  belongsTo(Seed)

✅ 7. UI / UX Requirements

Base UI

TailwindCSS styling

Flowbite components

Light/dark mode support

Clean, minimal design

Navigation

Persistent sidebar with SPA links (wire:navigate)

Header with:

Dark mode toggle

User menu (Profile / Security / Logout)

Mobile-responsive sidebar

Index Pages

Grid of cards using Flowbite card component

Card shows:

Image

Name

Clicking card → Show view

Show Pages

Full details

Related records displayed (e.g., Genus → Plants)

Buttons: Edit / Delete

Forms

Livewire form components

Image uploads for plants (up to 4) and seeds (up to 3)

Dropdowns:

Vendor

Location

Genus

Plant (for propagation)

Real-time validation

✅ 8. Livewire Components

Taxonomy

FamiliesIndex / FamilyForm / FamilyShow

SubfamiliesIndex / SubfamilyForm / SubfamilyShow

GeneraIndex / GenusForm / GenusShow

Plants

PlantsIndex / PlantForm / PlantShow

PlantPhotos (embedded)

Propagations

PropagationsIndex / PropagationForm / PropagationShow

Vendors

VendorsIndex / VendorForm

Locations

LocationsIndex / LocationForm

Seeds

SeedsIndex / SeedForm / SeedShow

SeedPhotos (embedded)

Dashboard

DashboardStats

✅ 9. Routes

All routes require authentication.

Uses SPA navigation (Livewire components):

/dashboard

/families

/families/{id}

/subfamilies

/subfamilies/{id}

/genera

/genera/{id}

/plants

/plants/{id}

/propagations

/propagations/{id}

/vendors

/locations

/seeds

/seeds/{id}

✅ 10. Image Upload Requirements

Use Livewire WithFileUploads

Validate: image|max:2048

Plants → max 4 images

Seeds → max 3 images

Store files under storage/app/public/{plants|seeds}

Auto-create photo records in plant_photos and seed_photos

✅ 11. Dashboard Requirements

The dashboard displays:

Total plants

Total seeds

Total propagations

Total families

Total subfamilies

Total genera

Total vendors

Total locations

Total collection value

All displayed in Flowbite stat cards.

✅ 12. Security Requirements

All queries must filter by user_id

Users cannot access each other's data

Fortify authentication is required for all protected routes

CSRF protection must be enabled

✅ 13. Scalability & Future Enhancements

Florabase is architected to support:

Subscription tiers (Stripe/Cashier)

Care reminders (cron + notifications)

Calendar view

Public plant pages

Import/export CSV

Tagging system

Advanced analytics dashboard

AI plant identification (future)

✅ 14. Acceptance Criteria

A complete v1 must include:

Working authentication

Fully functional sidebar + header

Dark mode toggle

All CRUD modules working

SPA navigation using Livewire

Image uploads working (plants + seeds)

Dashboard stats functioning

All user data properly isolated

Mobile responsive UI

Flowbite components styled

✅ 15. Codex Execution Notes

Codex must:

Generate migrations exactly matching schema

Generate models with relationships

Create Livewire v3 components

Use Flowbite UI

Implement SPA navigation with wire:navigate

Scope queries by user_id

Implement all CRUD operations

Support file uploads
