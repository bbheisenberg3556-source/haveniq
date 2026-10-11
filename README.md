# HavenIQ - Personality & Architecture

## Overview
HavenIQ is a platform where users design their ideal living room through a deeply detailed checklist. Based on their design choices, the platform generates:
1. A photorealistic rendering of the room (via Replicate API - Flux Schnell)
2. A customized personality profile (via Google Gemini 3.5 Flash Lite)

## Tech Stack
- **Backend**: Laravel 10
- **Frontend**: React (via Inertia.js)
- **Database**: MySQL (or SQLite for local dev)
- **Background Jobs**: Laravel Database Queues

## Setup Instructions

1. **Clone and Install**
   ```bash
   git clone <repo-url>
   cd ai-project
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Add your database credentials to `.env`.
   Add your API Keys:
   - `REPLICATE_API_TOKEN` (Replicate)
   - `GEMINI_API_KEY` (Google Gemini)

3. **Database and Migrations**
   ```bash
   php artisan migrate
   ```

4. **Running the Application locally**
   You need to run three separate processes in three terminal tabs:
   ```bash
   # Tab 1: Start Laravel server
   php artisan serve

   # Tab 2: Start Vite for React frontend
   npm run dev

   # Tab 3: Start the queue worker (crucial for API calls)
   php artisan queue:work
   ```
   The app will be available at `http://localhost:8000`.
# haveniq
# haveniq
