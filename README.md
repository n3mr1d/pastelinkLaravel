🔗 PasteLink - version Laravel 

Hi everyone!  
I'm Nameraid, a student and aspiring web developer. This project is an experiment and learning experience built using the Laravel framework.  
PasteLink is a platform that helps users manage and share links easily, whether it's for personal use or public sharing.

---

📌 Project Overview

PasteLink allows users to register and share any type of link.

Example JSON format for adding links:
```JSON
[
  {
    "title": "Title of the link you want to paste",
    "link": "https://example.com or http://example.onion",
    "category": ["Chat Room", "Marketplace", "Other"]
  }
]
```
Users can also use a classic single-add form via the website interface.

---

✨ Features

- Simple link submission via form or JSON
- Category system for organizing links
- Automatic dead-link checker
- User authentication for personalized link management
- Dashboard for managing and editing pasted links
- Support for `.onion` addresses (Tor)

---

⚙️ Tech Stack

- Backend: PHP 8+ using Laravel Framework
- Frontend: Blade + Bootstrap 
- Database: MySQL / SQLite
- Security: CSRF protection, hashed passwords, HTTPS support

---

🚧 Future Improvements

- Link expiration & scheduling
- Auto remove dead link featur

---

📁 Installation

1. Clone the repository:

   ```git clone https://github.com/n3mr1d/pastelinklaravel```

2. Navigate to the project folder:
   
   ```cd pastelinklaravel```

3. Install dependencies:
  ``` composer install```

4. Set up environment:

   ```cp .env.example .env php artisan key:generate```

5. Run migrations:
  ``` php artisan migrate ```

6. Start the server:

   ```php artisan serve```

---

#### Contribution & Feedback

Feel free to fork this project, submit pull requests, or open issues!  
If you have feedback or ideas, let’s connect!

---

Note: This project is educational and experimental.  
Not intended for production use without proper review and security hardening.

---

📜 License

MIT License © 2025 Nameraid
