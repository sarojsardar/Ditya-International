<?php
namespace App\Models;

use App\Http\Request;

class SendCode{

    public static function sendcode($code)
    {

        $otp = mt_rand(1000,9999);
        $message = 'Namaste!'."\n".
            'Your Ditya International Account Verification Code is '. $otp ;
        $code;
        $args = http_build_query(array(
            'token' => config('app.sms_token'),
            'from'  =>'TravelAlert',
            'to'    => $code,
            'text'  => $message));

        $url = config('app.sms_url');

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $otp;

    }


    public static function sendPasswordResetCode($mobileNumber, $otp)
    {
        $message = "Namaste!\nYour Ditya International Account Password Reset Code is " . $otp;

        $args = http_build_query([
            'token' => config('app.sms_token'),
            'from'  => 'TravelAlert',
            'to'    => $mobileNumber,
            'text'  => $message
        ]);

        $url = config('app.sms_url');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute the request
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Log the response and status code for debugging
        // Log::info("SMS Response: $response, Status Code: $status_code");

        return $otp; // You might want to adjust this based on whether you want to confirm the message was sent successfully
    }


    public static function interviewSms($mobileNumber, $interviewDate, $interviewTime, $interviewVenue, $companyName)
    {
        $message = "Namaste!\n" .
            "We'd like to invite you for interview :\n" .
            "Date: $interviewDate\n" .
            "Time: $interviewTime\n" .
            "Venue: $interviewVenue\n" .
            "Company Name: $companyName";

        $args = http_build_query([
            'token' => config('app.sms_token'),
            'from'  => 'TravelAlert',
            'to'    => $mobileNumber,
            'text'  => $message
        ]);

        $url = config('app.sms_url');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Uncomment this line if you want to enable SSL verification

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            // Handle error; log it or throw an exception
            error_log('SMS sending failed: ' . curl_error($ch));
            // Optionally, throw an exception or return false
        }

        curl_close($ch);

        // Optionally return response and status code or handle them as needed
        return [
            'response' => $response,
            'status_code' => $status_code
        ];
    }

    public static function reinterviewSms($mobileNumber, $interviewDate, $interviewTime, $interviewVenue, $companyName)
    {
        $message = "Namaste!\n" .
            "We'd like to invite you for Reinterview :\n" .
            "Date: $interviewDate\n" .
            "Time: $interviewTime\n" .
            "Venue: $interviewVenue\n" .
            "Company Name: $companyName";

        $args = http_build_query([
            'token' => config('app.sms_token'),
            'from'  => 'TravelAlert',
            'to'    => $mobileNumber,
            'text'  => $message
        ]);

        $url = config('app.sms_url');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Uncomment this line if you want to enable SSL verification

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            // Handle error; log it or throw an exception
            error_log('SMS sending failed: ' . curl_error($ch));
            // Optionally, throw an exception or return false
        }

        curl_close($ch);

        // Optionally return response and status code or handle them as needed
        return [
            'response' => $response,
            'status_code' => $status_code
        ];
    }

}
