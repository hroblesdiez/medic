{{--
Template Name: Legal Notice
--}}

@extends('layouts.app')

@section('content')
<article class="legal-page">
  <div class="container mx-auto px-4 py-16 max-w-4xl">
    <h1 class="text-4xl font-bold text-secondary mb-2">Legal Notice</h1>
    <p class="text-slate-500 mb-12">Last updated: June 2026</p>

    <div class="prose prose-slate max-w-none space-y-8">

      <section>
        <h2 class="text-2xl font-bold text-secondary mb-4">Identification</h2>
        <div class="bg-slate-50 p-6 rounded-lg border border-slate-200">
          <p class="font-semibold mb-2">Operator of this website:</p>
          <p class="mb-1">Humberto Robles Diez</p>
          <p class="mb-1">Warsaw, Poland</p>
          <p>Email: <a href="mailto:humberto.robles.diez@gmail.com" class="text-blue-600 hover:underline">humberto.robles.diez@gmail.com</a></p>
        </div>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-secondary mb-4">Portfolio Project Disclaimer</h2>
        <p class="text-slate-700 leading-relaxed mb-4">
          This website is a portfolio project created to demonstrate web development capabilities, including responsive design, modern web technologies, and best practices in user experience and accessibility. This is not a commercial medical practice or healthcare provider.
        </p>
        <p class="text-slate-700 leading-relaxed">
          The doctor profiles, appointment booking system, and all features are demonstration content only. No actual medical consultations are provided through this website. If you require genuine medical services, please contact a licensed healthcare provider in your area.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-secondary mb-4">Intellectual Property</h2>
        <p class="text-slate-700 leading-relaxed mb-4">
          All content on this website, including text, graphics, logos, images, and software, is the property of Humberto Robles Diez or is used with permission. You may not reproduce, distribute, or transmit any content without prior written consent, except for personal, non-commercial use.
        </p>
        <p class="text-slate-700 leading-relaxed">
          The website design, code, and architecture are proprietary and protected by copyright. Unauthorized access, copying, or modification of website code is prohibited.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-secondary mb-4">Disclaimer of Warranties</h2>
        <p class="text-slate-700 leading-relaxed">
          This website is provided on an "as is" basis. Humberto Robles Diez makes no representations or warranties, express or implied, regarding the website or its content. The website is provided without warranty of any kind, including fitness for a particular purpose, merchantability, or non-infringement. The entire risk as to the quality and performance of the website is with you.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-secondary mb-4">Limitation of Liability</h2>
        <p class="text-slate-700 leading-relaxed">
          To the fullest extent permitted by law, Humberto Robles Diez shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues, whether incurred directly or indirectly, resulting from your use of or inability to use the website or its content.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-secondary mb-4">Website Availability</h2>
        <p class="text-slate-700 leading-relaxed">
          Humberto Robles Diez does not guarantee that the website will be available at all times or free from interruption. We reserve the right to modify, suspend, or discontinue the website or any part thereof at any time without notice.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-secondary mb-4">Third-Party Links</h2>
        <p class="text-slate-700 leading-relaxed">
          This website may contain links to third-party websites. Humberto Robles Diez is not responsible for the content, accuracy, or practices of external websites. Your use of third-party websites is at your own risk and subject to their terms of service and privacy policies.
        </p>
      </section>

      <section>
        <h2 class="text-2xl font-bold text-secondary mb-4">Contact Information</h2>
        <p class="text-slate-700 leading-relaxed mb-4">
          For questions regarding this legal notice, privacy practices, or any concerns about this website, please contact:
        </p>
        <div class="bg-slate-50 p-6 rounded-lg border border-slate-200">
          <p class="mb-1"><strong>Email:</strong> <a href="mailto:humberto.robles.diez@gmail.com" class="text-blue-600 hover:underline">humberto.robles.diez@gmail.com</a></p>
          <p><strong>Location:</strong> Warsaw, Poland</p>
        </div>
      </section>

      <section class="pt-8 border-t border-slate-200">
        <p class="text-sm text-slate-500">
          This legal notice is subject to change without notice. Continued use of the website constitutes acceptance of any updates to this legal notice.
        </p>
      </section>

    </div>

    <div class="mt-12">
      <a href="{{ home_url('/') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Return to Homepage
      </a>
    </div>
  </div>
</article>
@endsection