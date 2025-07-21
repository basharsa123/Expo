<div style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: white; border-radius: 8px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">

        <h2 style="color: #2c3e50; font-size: 22px;">Hi {{ $user->name }},</h2>

        <p style="font-size: 16px; color: #34495e;">
            Thanks for joining <strong>our Expo</strong>! , You are registered to the lecture {{$lecture->title}} started at {{$lecture->started_at}} and ends at {{$lecture->finished_at}} .
        </p>

        <div style="width: 100%; max-width: 400px; margin: 0 auto; text-align: center; padding: 20px 10px; font-family: Arial, sans-serif;">
            <p style="font-size: 16px; color: #2c3e50; margin-bottom: 16px; line-height: 1.5;">
                Scan the QR code below and show it to the organizing team to join:
            </p>
            <div style="display: inline-block; padding: 16px; background: #f9f9f9; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); max-width: 100%;">
                <div style="max-width: 220px; margin: 0 auto; width: 100%;">
                    <div style="width: 100%; height: auto;">
                        {!! QrCode::format('svg')->size(200)->generate('https://example.com') !!}
                    </div>
                </div>
            </div>
            <p style="font-size: 12px; color: #95a5a6; margin-top: 14px;">
                Powered by OurExpo
            </p>
        </div>

        <p style="font-size: 16px; color: #34495e;">
            we are waiting for You!
        </p>

            <p style="font-size: 16px; color: #34495e;">

            </p>

        <p style="font-size: 14px; color: #bdc3c7; text-align: center; margin-top: 20px;">
            — The Expo Team
        </p>
    </div>
</div>
