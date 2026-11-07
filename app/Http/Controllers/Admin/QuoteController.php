<?php
namespace App\Http\Controllers\Admin;

use App\Enums\QuoteStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\{Artist, Quote};
use App\Services\QuoteService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function __construct(private QuoteService $quotes) {}

    public function index(Request $request)
    {
        $query = Quote::with('artist')->search($request->q)->latest();
        if ($request->filled('status')) $query->where('status', $request->status);

        return view('admin.quotes.index', ['quotes' => $query->paginate(15)->withQueryString(), 'statuses' => QuoteStatus::cases()]);
    }

    public function show(Quote $quote)
    {
        return view('admin.quotes.show', ['quote' => $quote->load('payments'), 'artists' => Artist::orderBy('name')->get(), 'statuses' => QuoteStatus::cases()]);
    }

    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        $this->quotes->update($quote, $request->validated());
        return redirect()->route('admin.quotes.show', $quote)->with('ok', 'Quote updated.');
    }
}
