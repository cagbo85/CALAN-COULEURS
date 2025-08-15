<?php

use App\Http\Controllers\Admin\Faq2Controller;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('faqs', [Faq2Controller::class, 'getAllFaqs2'])->name('admin.faqs.index');
    Route::get('faqs/create', [Faq2Controller::class, 'create'])->name('admin.faqs.create');
    Route::post('faqs/create', [Faq2Controller::class, 'store'])->name('admin.faqs.store');
    Route::get('faqs/{faqId}', [Faq2Controller::class, 'show'])->name('admin.faqs.show');
    Route::put('faqs/{faqId}', [Faq2Controller::class, 'update'])->name('admin.faqs.update');
    Route::delete('faqs/{faqId}', [Faq2Controller::class, 'destroy'])->name('admin.faqs.destroy');

    Route::post('faqs/bulk-activate', [Faq2Controller::class, 'bulkActivate'])->name('admin.faqs.bulk-activate');
    Route::post('faqs/bulk-mask', [Faq2Controller::class, 'bulkMask'])->name('admin.faqs.bulk-mask');

    Route::post('faqs/{faqId}/change-order', [Faq2Controller::class, 'changeOrder'])->name('admin.faqs.change-order');
});
