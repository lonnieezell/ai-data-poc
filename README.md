# AI-Powered Quality of Life Dataset Chatbot

A Laravel-based chatbot application that enables users to query a quality-of-life dataset through natural language using AI agents powered by Neuron PHP.

## Features

- **Natural Language Querying**: Ask questions about the dataset in plain English
- **Real-Time Streaming**: Server-Sent Events (SSE) for streaming AI responses
- **Session-Based Chat**: Lightweight conversation tracking without database persistence
- **Data Reference Sidebar**: Quick access to available data columns and their descriptions
- **Modern UI**: Clean, responsive interface built with Tailwind CSS v4

## Dataset

The application uses a dataset containing **10,000 rows** of quality-of-life metrics from [Kaggle](https://www.kaggle.com/datasets/oluwatosinadewale/quality-of-life-data).

**Available Data Points:**
- Gender
- Occupation Type
- Daily Work Hours
- Daily Rest Hours
- Daily Sleep Hours
- Daily Exercise Hours
- Age at Death

## Prerequisites

- PHP 8.3+
- Node.js (for frontend asset building)
- Composer
- SQLite (default) or another database engine

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd ai-data
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

4a. **Configure database**
   By default, the application is set to use SQLite. The Agent is currently setup to require a MySQL-compatible database (e.g., MySQL, MariaDB), update the `.env` file accordingly:
   ```env
   DB_CONNECTION=mariadb
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ai_data
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Import the dataset**
   The dataset CSV file is included at `resources/qol-dataset.csv` and run:

   ```bash
   php artisan app:import-qol-dataset
   ```

8. **Set up AI provider credentials**
    Open the `.env` file and set your AI provider API key and model:
   ```env
   OPENAI_API_KEY=your_openai_api_key_here
   OPENAI_MODEL=gpt-4o-mini
   ```

## Running the Application

### Development

1. **Start the Laravel development server:**
   ```bash
   php artisan serve
   ```

2. **In a new terminal, compile frontend assets:**
   ```bash
   npm run dev
   ```

   Or use the convenient Composer script:
   ```bash
   composer run dev
   ```

3. **Open the application** at `http://localhost:8000/chat`
