# PingerX – Real-Time Chat Application

PingerX is a real-time chat application built with Laravel and Livewire. It allows registered users to find other users, start conversations, exchange messages in real time, and manage their conversations through an interactive chat interface.

The project was developed to practice and demonstrate modern Laravel application development, authentication, real-time communication, database relationships, email verification, and responsive UI development.

---

## ✨ Features

### 🔐 Authentication & User Management

- User registration and login
- Email verification
- Password reset functionality
- Secure password hashing
- Authentication-protected chat features
- User profile information
- Profile pictures

### 💬 Real-Time Messaging

- One-to-one private conversations
- Real-time message delivery
- Send and receive messages without refreshing the page
- Message timestamps
- Read/unread message indicators
- Single and double check marks for message status
- Automatic chat updates

### 👥 Users & Conversations

- Browse registered users
- Find friends/users to start a conversation
- Automatically create a conversation when messaging a user
- Display existing conversations
- Search conversations by username
- Select conversations from the chat sidebar

### 🗑️ Conversation Management

- Delete conversations
- Delete associated messages
- Confirmation before permanently deleting a conversation
- Automatically refresh the conversation list after changes

### 📧 Email

- Email verification
- Password-related email functionality
- Resend integration for transactional emails

### 📱 Responsive Interface

- Desktop chat layout
- Responsive mobile interface
- Mobile-friendly conversation navigation
- Interactive chat sidebar
- User avatars
- Dropdown menus for conversation actions

---

## 🛠️ Technologies Used

### Backend

- PHP
- Laravel
- Laravel Livewire
- Laravel Breeze
- Eloquent ORM

### Frontend

- Blade
- Livewire
- HTML
- CSS
- JavaScript
- Alpine.js

### Database

- MySQL

### Real-Time Communication

- Pusher
- WebSockets

### Email

- Resend

### Development Tools

- Composer
- NPM
- Vite
- Git
- GitHub

---

## 🏗️ Project Structure

The application follows Laravel's MVC architecture and Livewire component structure.

```text
PingerX
├── app
│   ├── Livewire
│   │   └── Chat
│   │       ├── ChatBox.php
│   │       ├── ChatList.php
│   │       └── Index.php
│   ├── Models
│   │   ├── Conversation.php
│   │   ├── Message.php
│   │   └── User.php
│   └── ...
│
├── database
│   └── migrations
│
├── resources
│   └── views
│       └── livewire
│           ├── chat
│           └── pages
│
├── routes
│   ├── web.php
│   └── channels.php
│
├── public
│
├── storage
│
├── composer.json
├── package.json
└── README.md
```
## Installation

 Clone the repository

 
 ```bash
 git clone https://github.com/your-username/pingerx.git