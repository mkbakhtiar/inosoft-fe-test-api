# Laravel API for Product Search

This Laravel API provides endpoints for fetching filter options and searching product data based on various criteria.

## Prerequisites

- PHP 7.3 or higher
- Composer
- Laravel 8.x
- Git (optional, for cloning the repository)

## Installation

1. Clone the repository (or download and extract the ZIP file):
   ```
   git clone https://github.com/mkbakhtiar/inosoft-fe-test-api.git
   ```

2. Navigate to the project directory:
   ```
   cd inosoft-fe-test-api
   ```

3. Install the dependencies:
   ```
   composer install
   ```

4. Create a copy of the `.env.example` file and rename it to `.env`:
   ```
   cp .env.example .env
   ```

5. Generate an application key:
   ```
   php artisan key:generate
   ```

## Configuration

1. Open the `.env` file and configure your database settings if needed (although this API uses a JSON file for data, so database configuration is not strictly necessary).

2. Ensure that the `storage/app/private/data-inventories.json` file exists and contains the product data in the correct format.

## Running the API

1. Start the Laravel development server:
   ```
   php artisan serve
   ```

   The API will be available at `http://localhost:8000`.

## API Endpoints

### Get Filter Options

- **URL**: `/api/filters`
- **Method**: GET
- **Description**: Returns all unique values for each filter field (country_name, product_type, grade, connection, size).
- **Sample Response**:
  ```json
  {
    "filters": {
      "country_name": ["Indonesia", "Australia"],
      "product_type": ["Casing", "Sandscreen"],
      "grade": ["API 5L X60", "JFE-13CR-80"],
      "connection": ["Conductor", "Threaded & Coupled"],
      "size": [30, "5 1/2"]
    }
  }
  ```

### Search Products

- **URL**: `/api/search`
- **Method**: GET
- **Parameters**:
  - `country_name` (optional)
  - `product_type` (optional)
  - `grade` (optional)
  - `connection` (optional)
  - `size` (optional)
  - `searchText` (optional): For general text search across all fields
- **Description**: Searches and filters products based on the provided criteria.
- **Sample Request**: `/api/search?country_name=Indonesia&Product%20type=Casing&searchText=OCTG`
- **Sample Response**:
  ```json
  {
    "results": [
      {
        "id": 1,
        "code": "PS-11111",
        "item_id": 1,
        "qty": 283,
        "qty_unit": "Ea",
        "country_name": "Indonesia",
        "Item code": "OCTG-0134",
        "Item desc": "30\"\", 456.67 PPF, X56, PSL3, LYNX HDHT, R3",
        "product_type": "Casing",
        "grade": "API 5L X60",
        "connection": "Conductor",
        "size": "30"
      }
    ]
  }
  ```