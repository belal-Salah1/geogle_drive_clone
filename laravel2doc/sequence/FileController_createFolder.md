sequenceDiagram
    autonumber
    participant C as Client
    participant R as Route
    participant FileController as FileController
    participant Model as Model
    participant DB as Database
    
    C->>R: Request
    R->>+FileController: createFolder()
    Note over FileController: Process request
    alt Uses database
      FileController->>+Model: operation()
      Model->>+DB: Database query
      DB-->>-Model: Return data
      Model-->>-FileController: Return result
    else Direct response
      Note over FileController: Process without database
    end
    FileController-->>-R: Return response
    R-->>C: Response
    
    Note over FileController: Generic operation flow
  