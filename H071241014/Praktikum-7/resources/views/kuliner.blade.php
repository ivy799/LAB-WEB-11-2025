@extends('layouts.master')

@section('title', 'Kuliner - Eksplor Palembang')

@section('content')
<div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold mb-4">Kuliner Khas Palembang</h1>
        <p class="text-xl">Nikmati kelezatan cita rasa Palembang yang autentik</p>
    </div>
</div>

<div class="container mx-auto px-6 py-16">
    <div class="grid md:grid-cols-3 gap-8">
        <x-card 
            title="Pempek Kapal Selam"
            description="Ikon kuliner Palembang yang terkenal hingga seluruh Indonesia. Terbuat dari ikan tenggiri pilihan dan sagu, berisi telur ayam utuh di dalamnya. Disajikan dengan kuah cuko yang asam, pedas, dan manis. Teksturnya kenyal dan rasanya sangat khas."
            image="image/pempek.jpg"
        />
        
        <x-card 
            title="Tekwan"
            description="Sup bakso ikan khas Palembang yang disajikan dengan kuah kaldu udang yang gurih. Berisi potongan pempek kecil-kecil, soun, bengkoang, dan taburan daun seledri. Rasanya segar dan cocok dinikmati kapan saja, terutama saat cuaca panas."
            image="image/tekwan.jpg"
        />
        
        <x-card 
            title="Tempoyak"
            description="Tempoyak adalah durian yang difermentasi dan digunakan sebagai bumbu dalam berbagai hidangan. Tempoyak sering dimasak dengan ikan atau digunakan sebagai sambal. Rasa asam dan aroma khas durian yang kuat membuat hidangan dengan tempoyak sangat unik dan menggugah selera. "
            image="image/tempoyak.jpg"
        />
        
        <x-card 
            title="Celimpungan"
            description="Hidangan berkuah santan dengan ikan patin atau ikan gabus yang dibumbui rempah khas Palembang. Kuahnya kental, gurih, dan sedikit asam karena ditambah nanas atau belimbing. Biasanya dimakan dengan nasi putih hangat dan sambal."
            image="image/celimpungan.jpg"
        />
        
        <x-card 
            title="Mie Celor"
            description="Mie kuah khas Palembang dengan kuah santan yang gurih dan kental. Berisi mie tebal, tauge, telur rebus, dan irisan daun bawang. Kuahnya yang creamy dan rasa udang yang kuat membuat hidangan ini sangat nikmat dan mengenyangkan."
            image="image/mie celor.jpg"
        />
        
        <x-card 
            title="Lenggang"
            description="Telur dadar khas Palembang yang dicampur dengan ebi (udang kering) yang sudah dihaluskan. Teksturnya lembut dan aromanya harum. Biasanya disajikan dengan nasi putih dan sambal. Hidangan sederhana namun sangat lezat dan bergizi."
            image="image/lenggang.jpg"
        />
    </div>
</div>
@endsection