<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OrderPdfService;

class GenerateOrderPdf extends Command
{
    protected $signature = 'generate:order-pdf {order_id}';
    protected $description = 'Generate PDF for a specific order';

    public function handle(OrderPdfService $pdfService)
    {
        $orderId = $this->argument('order_id');

        $savePath = $pdfService->generate($orderId);

        if (!$savePath) {
            $this->error("Order ID {$orderId} not found.");
            return Command::FAILURE;
        }

        $this->info("PDF generated successfully!");
        $this->line("Saved at: {$savePath}");

        return Command::SUCCESS;
    }
}
