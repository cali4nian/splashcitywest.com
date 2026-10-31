<?php

use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');

Route::get('/terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms-and-conditions');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', [AdminSettingsController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/settings', [AdminSettingsController::class, 'settings'])->name('admin.settings');
    Route::get('/admin/newsletters', [AdminSettingsController::class, 'newsletters'])->name('admin.newsletters');
    Route::put('/admin/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('/admin/updates', [AdminSettingsController::class, 'storeUpdate'])->name('admin.updates.store');
    Route::put('/admin/updates/{update}', [AdminSettingsController::class, 'updateUpdate'])->name('admin.updates.update');
    Route::delete('/admin/updates/{update}', [AdminSettingsController::class, 'destroyUpdate'])->name('admin.updates.destroy');
    Route::post('/admin/highlight-links', [AdminSettingsController::class, 'storeHighlightLink'])->name('admin.highlight-links.store');
    Route::put('/admin/highlight-links/{highlightLink}', [AdminSettingsController::class, 'updateHighlightLink'])->name('admin.highlight-links.update');
    Route::delete('/admin/highlight-links/{highlightLink}', [AdminSettingsController::class, 'destroyHighlightLink'])->name('admin.highlight-links.destroy');
    Route::post('/admin/social-links', [AdminSettingsController::class, 'storeSocialLink'])->name('admin.social-links.store');
    Route::put('/admin/social-links/{socialLink}', [AdminSettingsController::class, 'updateSocialLink'])->name('admin.social-links.update');
    Route::delete('/admin/social-links/{socialLink}', [AdminSettingsController::class, 'destroySocialLink'])->name('admin.social-links.destroy');
    Route::post('/admin/donation-links', [AdminSettingsController::class, 'storeDonationLink'])->name('admin.donation-links.store');
    Route::put('/admin/donation-links/{donationLink}', [AdminSettingsController::class, 'updateDonationLink'])->name('admin.donation-links.update');
    Route::delete('/admin/donation-links/{donationLink}', [AdminSettingsController::class, 'destroyDonationLink'])->name('admin.donation-links.destroy');
    Route::post('/admin/staff', [AdminSettingsController::class, 'storeStaffMember'])->name('admin.staff.store');
    Route::put('/admin/staff/{staffMember}', [AdminSettingsController::class, 'updateStaffMember'])->name('admin.staff.update');
    Route::delete('/admin/staff/{staffMember}', [AdminSettingsController::class, 'destroyStaffMember'])->name('admin.staff.destroy');
    Route::post('/admin/newsletters', [AdminSettingsController::class, 'storeNewsletterContact'])->name('admin.newsletters.store');
    Route::post('/admin/newsletters/send', [AdminSettingsController::class, 'sendNewsletterCampaign'])->name('admin.newsletters.send');
    Route::post('/admin/newsletters/test-deliverability', [AdminSettingsController::class, 'testNewsletterContactDeliverability'])->name('admin.newsletters.test-deliverability');
    Route::post('/admin/newsletters/delete-all', [AdminSettingsController::class, 'destroyAllNewsletterContacts'])->name('admin.newsletters.destroy-all');
    Route::put('/admin/newsletters/{newsletterContact}', [AdminSettingsController::class, 'updateNewsletterContact'])->name('admin.newsletters.update');
    Route::delete('/admin/newsletters/{newsletterContact}', [AdminSettingsController::class, 'destroyNewsletterContact'])->name('admin.newsletters.destroy');
    Route::post('/admin/newsletters/import', [AdminSettingsController::class, 'importNewsletterContacts'])->name('admin.newsletters.import');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
