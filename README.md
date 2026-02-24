# Gresda Food - Premium E-Commerce Platform

Gresda Food is a modern, fully-featured e-commerce web application designed for a premium culinary ordering experience. This application has been extensively refactored to utilize a robust **MVC (Model-View-Controller)** architecture and a stunning, highly responsive UI powered by **Tailwind CSS**.

![Gresda Food](https://img.shields.io/badge/Status-Active_Development-brightgreen.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-purple.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC.svg)
![MVC Architecture](https://img.shields.io/badge/Architecture-MVC-blue.svg)

## 🌟 Key Highlights & UI/UX Features

- **Premium Design Language**: A cohesive, modern aesthetic using vibrant primary cyan colors, sleek typography, soft drop-shadows, and carefully tuned spacing margins.
- **Dynamic Animations (AOS)**: Stunning scroll-triggered animations (fade-ins, zoom-ins, slides) across all pages that give the application a lively and engaging feel.
- **Interactive Forms & Inputs**: Custom-styled input fields with animated focus rings, interactive password visibility toggles, and dynamic star-rating components for user reviews.
- **Advanced State Management**: Beautiful "empty states" (e.g., empty cart, empty menu, empty order history) utilizing engaging SVG-like illustrations and helpful empty-state actions.
- **Smart Navigation**: A sticky category sidebar for the Menu, dynamic scrollspy for Legal pages, and real-time cart badge indicators.
- **Secure Architecture**: Implementation of CSRF tokens on all forms, robust session management, input sanitization, and parameterized SQL queries (PDO) for robust security against XSS and SQL Injection.

## 🚀 Core Functionalities

### Customer Panel
- **Authentication**: Secure Login, Registration, and "Forgot Password" guided flows.
- **Catalog & Discovery**: Beautifully animated Menu page with live category filtering, item badges (Bestseller, Spicy, New), and interactive "Add to Cart" modals.
- **Advanced Cart System**: Dynamic cart counter, individual item quantity adjustments, and visually distinct empty states.
- **Seamless Checkout**: Streamlined checkout process with clear visual hierarchy, dynamic tax calculations, interactive payment method "cards", and integrated payment proof uploads.
- **Order Tracking**: Detailed order history with tabbed status filtering (All, Active, Completed, Cancelled) and a visual progress stepper for tracking delivery states.
- **User Dashboard**: Profile management panel, statistics overview, avatar uploads, and secure password updates.

### Admin Panel
*(Undergoing UX modernization to match the premium storefront)*
- **Dashboard Overview**: Financial summaries and recent transaction widgets.
- **Catalog Management**: Full CRUD operations for Food Items and Categories.
- **Order Fulfillment**: Track incoming orders, verify payment proofs, and update order statuses (Pending > Confirmed > Delivering > Complete).
- **User & Review Control**: Manage customer accounts, administrative privileges, and moderation of customer food reviews.
- **Data Tables**: Integrated searchable, sortable, and paginated data tables for robust data management.

## 🛠️ Technology Stack

- **Backend**: Native PHP 8+ (Custom MVC Routing Framework)
- **Database**: MySQL (PDO Extension)
- **Frontend Styling**: Tailwind CSS (Utility-first CSS)
- **Animations**: AOS (Animate on Scroll)
- **Icons**: FontAwesome 5/6
- **Interactions**: Vanilla JavaScript & SweetAlert2 (for elegant alerts)

## ⚙️ Local Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/kvnrynfl/Gresda-Food.git
   ```
2. **Server Setup**:
   - Place the project folder in your local server directory (e.g., `htdocs` for XAMPP or `www` for Laragon).
   - Ensure your local server is running PHP 8.0 or higher.
3. **Database Setup**:
   - Create a new MySQL database named `gresda-food`.
   - Import the provided SQL dump file (if available in `/gresda-food.sql`).
4. **Configuration**:
   - Navigate to `app/config/config.php` and update the database credentials (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`) as needed.
   - Update `BASEURL` in `config.php` to match your local development URL (e.g., `http://localhost/Gresda-Food/public`).
5. **Run**:
   - Access the application via your browser at your configured `BASEURL`.

---

> *This project has been heavily refactored from its original procedural PHP form into a modern MVC architecture, prioritizing enterprise-grade security, code maintainability, and top-tier user experience.*