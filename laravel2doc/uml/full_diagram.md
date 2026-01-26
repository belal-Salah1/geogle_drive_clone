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
  class AuthenticatedSessionController {
    <<Controller>>
    +create()
    +store(LoginRequest $request)
    +destroy(Request $request)
  }
  class ConfirmablePasswordController {
    <<Controller>>
    +show()
    +store(Request $request)
  }
  class EmailVerificationNotificationController {
    <<Controller>>
    +store(Request $request)
  }
  class EmailVerificationPromptController {
    <<Controller>>
    +__invoke(Request $request)
  }
  class NewPasswordController {
    <<Controller>>
    +create(Request $request)
    +store(Request $request)
  }
  class PasswordController {
    <<Controller>>
    +update(Request $request)
  }
  class PasswordResetLinkController {
    <<Controller>>
    +create()
    +store(Request $request)
  }
  class RegisteredUserController {
    <<Controller>>
    +create()
    +store(Request $request)
  }
  class VerifyEmailController {
    <<Controller>>
    +__invoke(EmailVerificationRequest $request)
  }
  class Controller {
    <<Controller>>
  }
  class FileController {
    <<Controller>>
    +myFiles()
    +createFolder(StoreFolderRequest $request)
  }
  class ProfileController {
    <<Controller>>
    +edit(Request $request)
    +update(ProfileUpdateRequest $request)
    +destroy(Request $request)
  }
