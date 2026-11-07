<?php
namespace App\Http\Controllers\Site;

use App\Enums\Coin;
use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreQuoteRequest, SubmitPaymentRequest};
use App\Models\{Artist, Quote};
use App\Services\QuoteService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function __construct(private QuoteService $quotes) {}

    public function create(Request $request)
    {
        return view('site.quote.create', ['artists' => Artist::orderBy('name')->get(), 'selected' => $request->artist, 'consult' => $request->boolean('consult')]);
    }

    public function store(StoreQuoteRequest $request)
    {
        $quote = $this->quotes->create($request->quoteData(), $request->file('reference'));
        return redirect()->route('quote.show', $quote->token)->with('ok', 'Request received. Bookmark this page to follow your quote.');
    }

    public function show(Quote $quote)
    {
        return view('site.quote.show', ['quote' => $quote->load(['artist', 'payments']), 'coins' => Coin::cases()]);
    }

    public function pay(SubmitPaymentRequest $request, Quote $quote)
    {
        abort_unless($quote->isPayable(), 403);
        $this->quotes->submitPayment($quote, Coin::from($request->coin), $request->txid);
        return back()->with('ok', 'Transaction submitted. We will confirm it once it is verified on-chain.');
    }
}
