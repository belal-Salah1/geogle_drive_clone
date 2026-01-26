sequenceDiagram
    autonumber
    participant C as Client
    participant R as Route
    participant FileController as FileController
    participant File as File
    participant DB as Database
    
    C->>R: Request
    R->>+FileController: myFiles()
    Note over FileController: Process request
    alt Uses database
      FileController->>+File: operation()
      File->>+DB: Database query
      DB-->>-File: Return data
      File-->>-FileController: Return result
    else Direct response
      Note over FileController: Process without database
    end
    FileController-->>-R: Return response
    R-->>C: Response
    
    Note over FileController: Generic operation flow
  