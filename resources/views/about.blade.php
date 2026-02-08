@extends('layouts.app')

@section('title', 'About Us - E-Mart')

@section('content')
<!-- About Hero Section -->
<section style="background: linear-gradient(135deg, var(--primary), var(--accent)); padding: 4rem 0; color: white;">
    <div class="container text-center">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; color: white;">About E-Mart</h1>
        <p style="font-size: 1.25rem; opacity: 0.9; max-width: 700px; margin: 0 auto;">Sri Lanka's trusted destination for quality electronics and gadgets at the best prices</p>
    </div>
</section>

<!-- Our Story Section -->
<section class="container" style="padding: 4rem 1.5rem;">
    <div class="grid grid-cols-2" style="gap: 3rem; align-items: center;">
        <div>
            <h2 style="margin-bottom: 1.5rem;">Our Story</h2>
            <p style="color: var(--text-secondary); line-height: 1.8; margin-bottom: 1rem;">
                Founded in 2023, E-Mart has quickly become Sri Lanka's leading online destination for electronics and technology products. 
                We started with a simple mission: to make quality technology accessible to every Sri Lankan household.
            </p>
            <p style="color: var(--text-secondary); line-height: 1.8; margin-bottom: 1rem;">
                Today, we serve thousands of customers across Sri Lanka, from Colombo to Jaffna, offering a curated selection of smartphones, 
                laptops, tablets, accessories, and more from the world's most trusted brands.
            </p>
            <p style="color: var(--text-secondary); line-height: 1.8;">
                Our commitment to customer satisfaction, competitive pricing, and island-wide delivery has made us the 
                go-to choice for tech enthusiasts and everyday shoppers throughout Sri Lanka.
            </p>
        </div>
        <div style="text-align: center;">
            <div style="background: var(--bg-secondary); padding: 3rem; border-radius: var(--radius-lg); box-shadow: var(--shadow);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
                <h3 style="margin-bottom: 0.5rem;">E-Mart</h3>
                <p style="color: var(--text-secondary);">Sri Lanka's Electronics Marketplace</p>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Values Section -->
<section style="background: var(--bg-secondary); padding: 4rem 0;">
    <div class="container">
        <h2 class="text-center mb-xl">Our Mission & Values</h2>
        <div class="grid grid-cols-3" style="gap: 2rem;">
            <div class="card text-center">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
                <h3 style="margin-bottom: 1rem;">Quality First</h3>
                <p style="color: var(--text-secondary);">We carefully curate our product selection to ensure only the best quality items reach our Sri Lankan customers.</p>
            </div>
            <div class="card text-center">
                <div style="font-size: 3rem; margin-bottom: 1rem;">💰</div>
                <h3 style="margin-bottom: 1rem;">Best Prices</h3>
                <p style="color: var(--text-secondary);">Competitive pricing in LKR and regular deals ensure you always get the best value for your money.</p>
            </div>
            <div class="card text-center">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🚀</div>
                <h3 style="margin-bottom: 1rem;">Island-Wide Delivery</h3>
                <p style="color: var(--text-secondary);">Fast and reliable delivery service to all provinces in Sri Lanka, from Colombo to the Northern Province.</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="container" style="padding: 4rem 1.5rem;">
    <div class="grid grid-cols-4" style="gap: 2rem; text-align: center;">
        <div>
            <div style="font-size: 3rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;">15K+</div>
            <p style="color: var(--text-secondary);">Happy Customers</p>
        </div>
        <div>
            <div style="font-size: 3rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;">500+</div>
            <p style="color: var(--text-secondary);">Products</p>
        </div>
        <div>
            <div style="font-size: 3rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;">50+</div>
            <p style="color: var(--text-secondary);">Brands</p>
        </div>
        <div>
            <div style="font-size: 3rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;">24/7</div>
            <p style="color: var(--text-secondary);">Support</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section style="background: var(--bg-secondary); padding: 4rem 0;">
    <div class="container">
        <h2 class="text-center mb-xl">Get In Touch</h2>
        <div class="grid grid-cols-3" style="gap: 2rem; max-width: 900px; margin: 0 auto;">
            <div class="card text-center">
                <div style="font-size: 2.5rem; margin-bottom: 1rem;">📧</div>
                <h4 style="margin-bottom: 0.5rem;">Email</h4>
                <p style="color: var(--text-secondary);">support@emart.lk</p>
            </div>
            <div class="card text-center">
                <div style="font-size: 2.5rem; margin-bottom: 1rem;">📱</div>
                <h4 style="margin-bottom: 0.5rem;">Phone</h4>
                <p style="color: var(--text-secondary);">+94 11 234 5678</p>
                <p style="color: var(--text-secondary); font-size: 0.9rem;">+94 77 123 4567</p>
            </div>
            <div class="card text-center">
                <div style="font-size: 2.5rem; margin-bottom: 1rem;">📍</div>
                <h4 style="margin-bottom: 0.5rem;">Address</h4>
                <p style="color: var(--text-secondary);">No. 123, Galle Road, Colombo 03, Sri Lanka</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="container" style="padding: 4rem 1.5rem; text-center;">
    <h2 style="margin-bottom: 1rem;">Ready to Shop?</h2>
    <p style="color: var(--text-secondary); margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
        Explore our wide range of products and find the perfect tech for your needs. All prices in Sri Lankan Rupees!
    </p>
    <a href="{{ url('/products') }}" class="btn btn-primary btn-lg">Browse Products</a>
</section>
@endsection
