# AlignMe

Ένα ολοκληρωμένο σύστημα που συνδυάζει **Backend (FastAPI + MySQL)** και **Frontend (Laravel + Tailwind)** για τη διαχείριση projects, αρχείων και σχέσεων.

---

## 📚 Documentation

### ⚙️ Backend

**Technologies**
- Python
- FastAPI
- MySQL

**Requirements**
- Python
- FastAPI
- rdflib

**API Functions (FastAPI)**

| Endpoint | Περιγραφή |
|----------|------------|
| `POST /register` | Δημιουργία νέου χρήστη |
| `POST /login` | Σύνδεση χρήστη |
| `GET /me` | Προβολή στοιχείων χρήστη |
| `GET /my-projects` | Λίστα projects του χρήστη |
| `GET /files` | Προβολή αρχείων |
| `POST /files/upload` | Ανέβασμα αρχείου |
| `GET /my-files` | Λίστα αρχείων χρήστη |
| `POST /files/{file_id}/parse` | Ανάλυση αρχείου |
| `GET /project-files/{project_id}` | Αρχεία project |
| `GET /nodes-details` | Στοιχεία κόμβων |
| `GET /project/{project_id}` | Στοιχεία project |
| `GET /projects` | Όλα τα projects |
| `GET /link-types` | Τύποι σχέσεων |
| `POST /project/{project_id}/suggestions/generate` | Δημιουργία προτάσεων |
| `GET /project/{project_id}/suggestions/read` | Προβολή προτάσεων |
| `POST /project/{project_id}/vote` | Ψήφος σε project |
| `GET /links` | Όλες οι σχέσεις |
| `POST /projects/{project_id}/links/{link_id}/score` | Βαθμολογία σχέσης |
| `GET /user-links` | Σχέσεις χρήστη |
| `GET /links/{link_id}` | Προβολή σχέσης |
| `POST /links/{link_id}/vote` | Ψήφος σε σχέση |
| `GET /projects/{project_id}/links` | Σχέσεις project |
| `GET /projects/{project_id}/export-links` | Εξαγωγή σχέσεων |

---

### 🎨 Frontend

**Technologies**
- Laravel
- PHP
- HTML
- Tailwind CSS

**Pages**
- 🏠 Welcome Page
- 🔑 Login Page
- 📝 Register Page
- 📊 Dashboard Page
- 📂 Project Page
- ➕ Create Project Page
- ⬆️ Upload File Page
- 🗳️ Vote Page

---

## 🚀 Getting Started

### Backend
```bash
# Εγκατάσταση απαιτήσεων
pip install fastapi uvicorn mysql-connector-python rdflib

# Εκκίνηση server
uvicorn main:app --reload


# Εγκατάσταση dependencies
composer install
npm install && npm run dev

# Εκκίνηση Laravel server
php artisan serve
