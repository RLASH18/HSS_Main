# System Overview

## About ABG Prime Builders Supplies Inc.

**ABG Prime Builders Supplies Inc.**  
L28, Block 11, km 17 Commonwealth Ave, Quezon City, 1127 Metro Manila

This Inventory and Order Management System was developed as a **thesis project** focusing on **Parallel and Distributed Systems**. The system demonstrates distributed architecture through its modular design, with separate functional modules handling different aspects of the business operations.

---

## Thesis Project Context

**Project Type**: Parallel and Distributed System  
**Architecture**: Distributed Modular System

The system is designed as a **distributed system** with independent modules that work together to provide a complete inventory and order management solution. Each module operates semi-independently while sharing data through a common database layer, demonstrating key distributed system principles.

---

## System Architecture

### Admin Side Modules

The administrative interface consists of five main modules:

#### 1. Inventory Module
- **Items Management**: CRUD operations for product catalog
- **Supplier Management**: Manage supplier information and relationships
- Track stock levels and product details

#### 2. Orders Module
- View and manage customer orders
- Order status tracking
- Order processing workflow

#### 3. Billing Module
- Generate billing information for orders
- Track payment status
- Payment method management
- Print receipts (bond paper format)

#### 4. Delivery Module
- Manage delivery schedules
- Track delivery status
- Proof of delivery uploads
- Delivery status updates (Pending → Assembled → In Transit → Delivered)

#### 5. Reports Module
- Generate business reports
- Analytics and insights
- Order and inventory reporting

### Customer Side Features

The customer-facing interface provides a complete e-commerce experience:

#### Shopping Features
- **Browse Items**: View product catalog with details
- **Shopping Cart**: Add items to cart
- **Checkout Process**: Complete purchase workflow

#### Payment Options
- **Cash on Delivery (COD)**: Pay upon delivery
- **GCash**: Mobile wallet payment
- **Bank Transfer**: Direct bank payment

**Payment Gateway**: [PayMongo](https://www.paymongo.com/) integration for secure online payments

---

## Third-Party Integrations

### 1. Email Validation - Abstract API
**Purpose**: User registration email verification  
**Service**: [Abstract API](https://www.abstractapi.com/)

- Validates email addresses during registration
- Checks if email exists and is deliverable
- Prevents ghost/fake email registrations
- Ensures email quality and authenticity

### 2. SMS Notifications - TextBee API
**Purpose**: Delivery status notifications  
**Service**: TextBee API

**Trigger**: When delivery status changes to "Assembled"  
**Action**: Customer receives SMS notification that their order is ready for delivery

### 3. Email Notifications - SMTP Gmail
**Purpose**: Account verification and order confirmation emails  
**Service**: Gmail SMTP

#### Use Case 1: Account Creation
**Trigger**: When customer creates a new account  
**Action**: System sends email with:
- 6-digit verification code
- Account activation instructions
- Security information

#### Use Case 2: Order Confirmation
**Trigger**: When order status changes to "Confirmed"  
**Action**: System sends email to customer with:
- Order confirmation details
- List of purchased products
- Order summary and information

---

## System Workflow

### Customer Registration Flow
1. Customer fills out registration form
2. System validates email using Abstract API
3. System sends 6-digit verification code via Gmail SMTP
4. Customer enters verification code
5. Account is activated

### Customer Order Flow
1. Customer browses items and adds to cart
2. Customer proceeds to checkout
3. Customer selects payment method (COD/GCash/Bank Transfer)
4. Order is created with "Pending" status
5. Admin confirms order → Status: "Confirmed"
   - Email sent to customer with order details
6. Admin prepares order → Status: "Assembled"
   - SMS sent to customer
7. Order is shipped → Status: "In Transit"
8. Order delivered → Status: "Delivered"

### Admin Management Flow
1. Manage inventory (items and suppliers)
2. Process incoming orders
3. Generate billing for confirmed orders
4. Schedule and track deliveries
5. Generate reports for business insights

---

## Security Features

- **Email Validation**: Prevents fake account creation
- **CSRF Protection**: Built-in token validation
- **Session Management**: Secure session handling
- **Payment Security**: PayMongo PCI-compliant payment processing

---

## Communication Channels

| Event | Channel | Provider | Recipient |
|-------|---------|----------|-----------|
| Account Creation | Email (6-digit code) | Gmail SMTP | Customer |
| Order Confirmed | Email | Gmail SMTP | Customer |
| Order Assembled | SMS | TextBee API | Customer |
| Registration | Email Validation | Abstract API | System |

---

## Technology Stack

- **Backend Framework**: Custom PHP MVC Framework
- **Database**: MySQL/MariaDB
- **Payment Gateway**: PayMongo
- **Email Service**: Gmail SMTP
- **SMS Service**: TextBee API
- **Email Validation**: Abstract API
- **Frontend**: Tailwind CSS + Flowbite

---

## Notes

This system demonstrates distributed architecture principles through:
- **Modular Design**: Independent functional modules
- **Service Integration**: Multiple third-party services working together
- **Asynchronous Communication**: Email and SMS notifications
- **Scalable Architecture**: Each module can be scaled independently

---

> **Developed for**: ABG Prime Builders Supplies Inc.  
> **Project Type**: Thesis - Parallel and Distributed System  
> **Framework**: Custom PHP MVC Framework
