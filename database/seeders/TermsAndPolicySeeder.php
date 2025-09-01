<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TermsAndPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $data = [
            [
                'key'    => 'Terms-and-Conditions',
                'value'  => <<<HTML
<p>
  These Terms govern your use of the <b>WMNZZ</b> mobile application ("App").
  By using the App, you agree to be bound by these terms.
</p>

<strong>1. Eligibility</strong>
<p>You must be at least 13 years old to use the app.</p>

<strong>2. Use of the App</strong>
<p>You agree to use the App for personal, non-commercial purposes and not to misuse it in any way.</p>

<strong>3. Health Disclaimer</strong>
<p>
  The App provides health-related information and predictions for general awareness only.
  It is not a substitute for professional medical advice. Always consult a doctor for medical concerns.
</p>

<strong>4. Intellectual Property</strong>
<p>
  All content, design, and branding in the App are owned by <b>WMNZZ</b> and
  may not be copied or reused without permission.
</p>

<strong>5. User Content</strong>
<p>You may input personal or health data. You are responsible for the accuracy of this data.</p>

<strong>6. Termination</strong>
<p>We reserve the right to suspend or terminate access to the app if you violate these terms.</p>

<strong>7. Limitation of Liability</strong>
<p>We are not responsible for any health outcomes or decisions made based on the app’s content.</p>

<strong>8. Governing Law</strong>
<p>
  These terms are governed by the laws of India. Any disputes shall be subject to the jurisdiction
  of <b>Tamilnadu</b> courts.
</p>

<strong>9. Contact</strong>
<p>
  For questions about these Terms, reach us at:<br>
  📧 Email: <b>info.wmnzz@gmail.com</b><br>
  📍 Address: <b>Theni</b>
</p>
HTML,
                'status' => 1,
            ],
            [
                'key'    => 'Privacy-Policy',
                'value'  => <<<HTML
<p>
  WMNZZ ("we", "us", or "our") respects your privacy. This Privacy Policy explains how 
  we collect, use, and protect your personal information when you use our period tracking
  mobile application ("App").
</p>

<strong>1. Information We Collect</strong>
<p>We may collect the following types of information:</p>
<ul>
  <li>Personal Information: Name, email address, age, etc.</li>
  <li>Health Data: Menstrual cycle dates, symptoms, mood, ovulation, pregnancy, etc.</li>
  <li>Device Information: IP address, device type, operating system, app usage statistics.</li>
</ul>

<strong>2. Purpose of Data Collection</strong>
<ul>
  <li>Provide personalized cycle predictions and reminders</li>
  <li>Improve app features and user experience</li>
  <li>Send notifications and alerts related to your cycle</li>
  <li>Respond to support queries</li>
</ul>

<strong>3. Data Sharing and Disclosure</strong>
<p>
  We do not sell your personal or health data. We may share data with trusted third-party
  service providers for analytics, cloud storage, or notifications.
</p>
<p>Authorities, if required by law.</p>

<strong>4. Your Rights</strong>
<ul>
  <li>You can access, edit, or delete your personal data within the app settings.</li>
  <li>You may withdraw consent at any time by uninstalling the app or contacting us.</li>
</ul>

<strong>5. Data Security</strong>
<p>We use industry-standard encryption and security practices to protect your data.</p>

<strong>6. Children’s Privacy</strong>
<p>This app is not intended for users under the age of 13. We do not knowingly collect data from minors.</p>

<strong>7. Third-Party Services</strong>
<p>Our app may include links or integrations to third-party tools. Their privacy policies apply to your use of those services.</p>

<strong>8. Changes to Policy</strong>
<p>We may update this policy. Any changes will be posted here with a new effective date.</p>

<strong>9. Contact</strong>
<p>
  If you have questions, contact us at:<br>
  📧 Email: <b>info.wmnzz@gmail.com</b><br>
  📍 Address: <b>Theni</b>
</p>
HTML,
                'status' => 1,
            ],
        ];

        foreach ($data as $item) {
            \DB::table('settings')->updateOrInsert(
                ['key' => $item['key']],
                ['value' => $item['value'], 'status' => $item['status'], 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}
