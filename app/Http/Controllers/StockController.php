<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('product')->get();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        // Si vous avez besoin de créer un stock manuellement, vous pouvez l'ajouter ici.
        // Cela dépendra de votre logique métier.
    }

//     public function downloadPDF()
// {
//     $stocks = Stock::with('product')->get();
//     $pdf = PDF::loadView('stocks-pdf', compact('stocks'));
//     return $pdf->download('stocks.pdf');
// }
public function downloadPDF($id)
{
    $stocks = Stock::with('product')->get();

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);

    $dompdf = new Dompdf($options);
    $html = view('stocks.pdf', compact('stocks'))->render();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $dompdf->stream('stocks.pdf');
}




    public function show($id)
    {
        $stock = Stock::with('product')->findOrFail($id);
        return view('stocks.show', compact('stock'));
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stocks.edit', compact('stock'));
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        $stock->update($request->all());
        return redirect()->route('stocks.index')->with('success', 'Stock mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock supprimé avec succès.');
    }
}
