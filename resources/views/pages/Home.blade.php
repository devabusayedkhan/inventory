@extends('App')
@section('content')


<section class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <h2 class="text-4xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h2>
    <p class="text-gray-500 mb-12">Choose a plan that fits your needs. No hidden fees.</p>

    <div class="grid gap-8 md:grid-cols-3">
      <!-- Free Plan -->
      <div class="border rounded-2xl p-6 shadow hover:shadow-lg transition">
        <h3 class="text-2xl font-semibold mb-4">Free</h3>
        <p class="text-4xl font-bold mb-4">$0<span class="text-lg font-normal text-gray-500">/mo</span></p>
        <ul class="text-left space-y-2 text-gray-600 mb-6">
          <li>✅ 1 Project</li>
          <li>✅ Basic Support</li>
          <li>✅ Community Access</li>
        </ul>
        <a href="/loginRegister" class="w-full bg-gray-900 text-white py-2 rounded-xl hover:bg-gray-700 transition block cursor-pointer">Get Started</a>
      </div>

      <!-- Pro Plan (Highlighted) -->
      <div class="border-2 border-blue-600 rounded-2xl p-6 shadow-lg transform scale-105 bg-blue-50">
        <h3 class="text-2xl font-semibold mb-4 text-blue-700">Pro</h3>
        <p class="text-4xl font-bold mb-4 text-blue-800">$29<span class="text-lg font-normal text-blue-600">/mo</span></p>
        <ul class="text-left space-y-2 text-blue-900 mb-6">
          <li>✅ 10 Projects</li>
          <li>✅ Priority Support</li>
          <li>✅ Analytics Dashboard</li>
        </ul>
        <button class="w-full bg-blue-600 text-white py-2 rounded-xl hover:bg-blue-700 transition">Try Pro</button>
      </div>

      <!-- Enterprise Plan -->
      <div class="border rounded-2xl p-6 shadow hover:shadow-lg transition">
        <h3 class="text-2xl font-semibold mb-4">Enterprise</h3>
        <p class="text-4xl font-bold mb-4">Custom</p>
        <ul class="text-left space-y-2 text-gray-600 mb-6">
          <li>✅ Unlimited Projects</li>
          <li>✅ Dedicated Support</li>
          <li>✅ Custom Integrations</li>
        </ul>
        <button class="w-full bg-gray-900 text-white py-2 rounded-xl hover:bg-gray-700 transition">Contact Sales</button>
      </div>
    </div>
  </div>
</section>




@endsection