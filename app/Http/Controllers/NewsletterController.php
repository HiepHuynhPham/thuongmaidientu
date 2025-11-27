<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
        ]);

        $apiKey = config('services.mailchimp.key');
        $audienceId = config('services.mailchimp.audience_id') ?: config('services.mailchimp.audience');
        $serverPrefix = config('services.mailchimp.server_prefix');
        $dataCenter = $serverPrefix ?: ($apiKey && str_contains($apiKey, '-') ? Str::after($apiKey, '-') : null);

        if (!$apiKey || !$audienceId || !$dataCenter) {
            return back()->with('error', 'Mailchimp chưa được cấu hình (API key, audience/list, server prefix).');
        }

        $memberId = md5(strtolower($data['email']));
        $url = "https://{$dataCenter}.api.mailchimp.com/3.0/lists/{$audienceId}/members/{$memberId}";

        $response = Http::withBasicAuth('anystring', $apiKey)
            ->put($url, [
                'email_address' => $data['email'],
                'status_if_new' => 'subscribed',
                'merge_fields' => [
                    'FNAME' => $data['name'] ?? '',
                ],
            ]);

        if ($response->failed()) {
            $json = $response->json();
            $title = is_array($json) ? ($json['title'] ?? null) : null;
            $detail = is_array($json) ? ($json['detail'] ?? null) : null;
            $statusCode = $response->status();
            if ($title === 'Member Exists') {
                return back()->with('success', 'Bạn đã đăng ký nhận tin trước đó.');
            }
            return back()->with('error', 'Không thể đăng ký Mailchimp: ' . ($detail ?? $title ?? ('HTTP ' . $statusCode)));
        }

        return back()->with('success', 'Đăng ký nhận tin thành công!');
    }

    public function export(): StreamedResponse
    {
        if (session('role_id') !== 1) {
            abort(403);
        }

        $users = User::whereNotNull('user_email')->select('user_email', 'user_name')->get();

        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Email', 'Tên']);
            foreach ($users as $user) {
                fputcsv($handle, [$user->user_email, $user->user_name]);
            }
            fclose($handle);
        };

        $fileName = 'newsletter-emails-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
