classDiagram
  class File {
    +//     name
    +//     path
    +//     is_folder
    +//     mime
    +//     size
    +//     created_by
    +//     updated_by
    +//     parent_id
    +//     _lft
    +//     _rgt
    +//
    +isOwnedBy($userId)
  }
  class FileShare {
  }
  class starredFile {
  }
  class User {
    +name
    +email
    +password
  }
