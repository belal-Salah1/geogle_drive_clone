# API Documentation

## Project: laravel/laravel

Laravel Version: v12.48.1

Generated: 1/26/2026, 5:23:42 PM

## Table of Contents

- [auth](#auth)
- [web](#web)

## auth

| Method | Endpoint | Handler | Description |
|--------|----------|---------|-------------|
| GET | register | RegisteredUserController::class, 'create' | List register |
| POST | register | RegisteredUserController::class, 'store' | Create a new register |
| GET | login | AuthenticatedSessionController::class, 'create' | List login |
| POST | login | AuthenticatedSessionController::class, 'store' | Create a new login |
| GET | forgot-password | PasswordResetLinkController::class, 'create' | List forgot-password |
| POST | forgot-password | PasswordResetLinkController::class, 'store' | Create a new forgot-password |
| GET | reset-password/{token} | NewPasswordController::class, 'create' | Retrieve a specific {token} |
| POST | reset-password | NewPasswordController::class, 'store' | Create a new reset-password |
| GET | verify-email | EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1' | List verify-email |
| POST | email/verification-notification | EmailVerificationNotificationController::class, 'store' | Create a new verification-notification |
| GET | confirm-password | ConfirmablePasswordController::class, 'show' | List confirm-password |
| POST | confirm-password | ConfirmablePasswordController::class, 'store' | Create a new confirm-password |
| PUT | password | PasswordController::class, 'update' | Update a specific password |
| POST | logout | AuthenticatedSessionController::class, 'destroy' | Create a new logout |

### GET register

**Handler:** RegisteredUserController::class, 'create'

**Description:** List register

---

### POST register

**Handler:** RegisteredUserController::class, 'store'

**Description:** Create a new register

---

### GET login

**Handler:** AuthenticatedSessionController::class, 'create'

**Description:** List login

---

### POST login

**Handler:** AuthenticatedSessionController::class, 'store'

**Description:** Create a new login

---

### GET forgot-password

**Handler:** PasswordResetLinkController::class, 'create'

**Description:** List forgot-password

---

### POST forgot-password

**Handler:** PasswordResetLinkController::class, 'store'

**Description:** Create a new forgot-password

---

### GET reset-password/{token}

**Handler:** NewPasswordController::class, 'create'

**Description:** Retrieve a specific {token}

---

### POST reset-password

**Handler:** NewPasswordController::class, 'store'

**Description:** Create a new reset-password

---

### GET verify-email

**Handler:** EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'

**Description:** List verify-email

---

### POST email/verification-notification

**Handler:** EmailVerificationNotificationController::class, 'store'

**Description:** Create a new verification-notification

---

### GET confirm-password

**Handler:** ConfirmablePasswordController::class, 'show'

**Description:** List confirm-password

---

### POST confirm-password

**Handler:** ConfirmablePasswordController::class, 'store'

**Description:** Create a new confirm-password

---

### PUT password

**Handler:** PasswordController::class, 'update'

**Description:** Update a specific password

---

### POST logout

**Handler:** AuthenticatedSessionController::class, 'destroy'

**Description:** Create a new logout

---

## web

| Method | Endpoint | Handler | Description |
|--------|----------|---------|-------------|
| GET | / | function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
     | List resource |
| GET | /my-files | 'myFiles')->name('myFiles');
Route::get('/folder/create','createFolder')->name('folder.create');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');




})->middleware(['auth', 'verified' | List my-files |
| GET | /profile | ProfileController::class, 'edit' | List profile |
| PATCH | /profile | ProfileController::class, 'update' | Update a specific profile |
| DELETE | /profile | ProfileController::class, 'destroy' | Delete a specific profile |
| GET | /test-mail | function () {
    Mail::raw('Test email from Laravel', function ($msg) {
        $msg->to('test@example.com')->subject('Mailpit Test 2');
    });

    return 'Mail sent!';
});

require __DIR__.'/auth.php';
 | List test-mail |

### GET /

**Handler:** function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    

**Description:** List resource

---

### GET /my-files

**Handler:** 'myFiles')->name('myFiles');
Route::get('/folder/create','createFolder')->name('folder.create');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');




})->middleware(['auth', 'verified'

**Description:** List my-files

---

### GET /profile

**Handler:** ProfileController::class, 'edit'

**Description:** List profile

---

### PATCH /profile

**Handler:** ProfileController::class, 'update'

**Description:** Update a specific profile

---

### DELETE /profile

**Handler:** ProfileController::class, 'destroy'

**Description:** Delete a specific profile

---

### GET /test-mail

**Handler:** function () {
    Mail::raw('Test email from Laravel', function ($msg) {
        $msg->to('test@example.com')->subject('Mailpit Test 2');
    });

    return 'Mail sent!';
});

require __DIR__.'/auth.php';


**Description:** List test-mail

---

