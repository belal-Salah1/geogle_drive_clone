erDiagram
  file {
    int id PK "Primary key"
    string name
    string path
    boolean is_folder
    string mime
    string size
    string created_by
    datetime updated_by
    int parent_id FK "References parent"
    string _lft
    string _rgt
    datetime created_at
    datetime updated_at
  }
  user {
    int id PK "Primary key"
    string name
    string email
    string password
    datetime created_at
    datetime updated_at
  }
