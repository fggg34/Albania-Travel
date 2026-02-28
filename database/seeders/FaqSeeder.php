<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // Category 1: Booking & Reservations
            [
                'category'      => 'Booking & Reservations',
                'category_icon' => 'fa-solid fa-calendar-check',
                'category_sort' => 10,
                'sort_order'    => 1,
                'question'      => 'How do I book a tour?',
                'answer'        => "You can book directly on our website by selecting a tour, choosing your preferred date and number of travellers, and completing the booking form. You'll receive a confirmation email with all the details. No account is required.",
            ],
            [
                'category'      => 'Booking & Reservations',
                'category_icon' => 'fa-solid fa-calendar-check',
                'category_sort' => 10,
                'sort_order'    => 2,
                'question'      => 'Do I need to pay in advance?',
                'answer'        => 'Yes, we require payment at the time of booking to secure your spot. This helps us manage group sizes and ensure the best experience for everyone.',
            ],
            [
                'category'      => 'Booking & Reservations',
                'category_icon' => 'fa-solid fa-calendar-check',
                'category_sort' => 10,
                'sort_order'    => 3,
                'question'      => 'Can I book a private tour?',
                'answer'        => "Absolutely! We offer private and customised tours for individuals, couples, families, and groups. Contact us with your preferences and we'll create a tailored itinerary just for you.",
            ],
            [
                'category'      => 'Booking & Reservations',
                'category_icon' => 'fa-solid fa-calendar-check',
                'category_sort' => 10,
                'sort_order'    => 4,
                'question'      => 'How far in advance should I book?',
                'answer'        => 'We recommend booking at least 3–5 days in advance, especially during peak season (June–September). Popular tours can fill up quickly, so the earlier the better.',
            ],
            [
                'category'      => 'Booking & Reservations',
                'category_icon' => 'fa-solid fa-calendar-check',
                'category_sort' => 10,
                'sort_order'    => 5,
                'question'      => 'Can I book for a large group?',
                'answer'        => 'Yes! We accommodate groups of all sizes. For parties of 10 or more, please contact us directly so we can arrange the best experience and pricing for your group.',
            ],

            // Category 2: Payments & Pricing
            [
                'category'      => 'Payments & Pricing',
                'category_icon' => 'fa-solid fa-credit-card',
                'category_sort' => 20,
                'sort_order'    => 1,
                'question'      => 'What payment methods do you accept?',
                'answer'        => 'We accept major credit and debit cards (Visa, Mastercard, American Express). For some tours, bank transfers and cash payment on arrival may be available. Payment options are shown during checkout.',
            ],
            [
                'category'      => 'Payments & Pricing',
                'category_icon' => 'fa-solid fa-credit-card',
                'category_sort' => 20,
                'sort_order'    => 2,
                'question'      => 'Are there any hidden fees?',
                'answer'        => 'No. The price you see on our website is the total price. All entrance fees, guide services, and transport (when listed) are included. We believe in full transparency.',
            ],
            [
                'category'      => 'Payments & Pricing',
                'category_icon' => 'fa-solid fa-credit-card',
                'category_sort' => 20,
                'sort_order'    => 3,
                'question'      => 'Do you offer discounts for children?',
                'answer'        => 'Yes, children under 12 typically receive a reduced rate, and infants (under 2) are often free. Specific pricing is shown on each tour page.',
            ],
            [
                'category'      => 'Payments & Pricing',
                'category_icon' => 'fa-solid fa-credit-card',
                'category_sort' => 20,
                'sort_order'    => 4,
                'question'      => 'What currency are your prices in?',
                'answer'        => 'All prices on our website are displayed in Euros (€). Payments are processed in EUR.',
            ],

            // Category 3: Cancellations & Changes
            [
                'category'      => 'Cancellations & Changes',
                'category_icon' => 'fa-solid fa-rotate-left',
                'category_sort' => 30,
                'sort_order'    => 1,
                'question'      => 'What is your cancellation policy?',
                'answer'        => 'Free cancellation is available up to 48 hours before the tour start time. Cancellations within 48 hours may be subject to a fee. Specific policies are noted on each tour page.',
            ],
            [
                'category'      => 'Cancellations & Changes',
                'category_icon' => 'fa-solid fa-rotate-left',
                'category_sort' => 30,
                'sort_order'    => 2,
                'question'      => 'Can I change my booking date?',
                'answer'        => 'Yes, you can reschedule your tour at no additional cost, subject to availability. Contact us at least 48 hours before your original tour date.',
            ],
            [
                'category'      => 'Cancellations & Changes',
                'category_icon' => 'fa-solid fa-rotate-left',
                'category_sort' => 30,
                'sort_order'    => 3,
                'question'      => 'What happens if a tour is cancelled due to weather?',
                'answer'        => 'Safety is our priority. If a tour is cancelled due to severe weather, you will be offered an alternative date or a full refund. We will notify you as soon as possible.',
            ],
            [
                'category'      => 'Cancellations & Changes',
                'category_icon' => 'fa-solid fa-rotate-left',
                'category_sort' => 30,
                'sort_order'    => 4,
                'question'      => 'How do I request a refund?',
                'answer'        => 'Contact us via email or phone with your booking reference. Refunds are processed within 5–10 business days to the original payment method.',
            ],

            // Category 4: Travelling in Albania
            [
                'category'      => 'Travelling in Albania',
                'category_icon' => 'fa-solid fa-plane',
                'category_sort' => 40,
                'sort_order'    => 1,
                'question'      => 'Is Albania safe for tourists?',
                'answer'        => 'Yes, Albania is considered very safe for tourists. Albanians are known for their hospitality and warmth. As with any destination, we recommend standard precautions like watching your belongings in crowded areas.',
            ],
            [
                'category'      => 'Travelling in Albania',
                'category_icon' => 'fa-solid fa-plane',
                'category_sort' => 40,
                'sort_order'    => 2,
                'question'      => 'Do I need a visa to visit Albania?',
                'answer'        => "EU, US, UK, Canadian, and Australian citizens can visit Albania visa-free for up to 90 days. Check the Albanian Ministry of Foreign Affairs website for the latest entry requirements for your nationality.",
            ],
            [
                'category'      => 'Travelling in Albania',
                'category_icon' => 'fa-solid fa-plane',
                'category_sort' => 40,
                'sort_order'    => 3,
                'question'      => 'What is the best time to visit Albania?',
                'answer'        => 'The best time for tours is from April to October. Summer (June–August) is ideal for the coast and beaches. Spring and autumn are perfect for hiking, cultural tours, and avoiding crowds.',
            ],
            [
                'category'      => 'Travelling in Albania',
                'category_icon' => 'fa-solid fa-plane',
                'category_sort' => 40,
                'sort_order'    => 4,
                'question'      => 'What should I pack for a tour in Albania?',
                'answer'        => 'Comfortable walking shoes, sunscreen, a hat, and layered clothing (temperatures can vary). For beach/coastal tours, bring swimwear. For mountain tours, we recommend waterproof outerwear.',
            ],
            [
                'category'      => 'Travelling in Albania',
                'category_icon' => 'fa-solid fa-plane',
                'category_sort' => 40,
                'sort_order'    => 5,
                'question'      => 'What language is spoken in Albania?',
                'answer'        => 'The official language is Albanian. English is widely spoken in tourist areas, especially by younger Albanians. Our guides are fluent in English and several other languages.',
            ],
            [
                'category'      => 'Travelling in Albania',
                'category_icon' => 'fa-solid fa-plane',
                'category_sort' => 40,
                'sort_order'    => 6,
                'question'      => 'What is the local currency?',
                'answer'        => 'The local currency is the Albanian Lek (ALL). Euros are widely accepted in tourist areas. ATMs are readily available in cities and towns. Credit cards are accepted at most hotels and restaurants.',
            ],

            // Category 5: Tour Experience
            [
                'category'      => 'Tour Experience',
                'category_icon' => 'fa-solid fa-compass',
                'category_sort' => 50,
                'sort_order'    => 1,
                'question'      => 'What is included in the tour price?',
                'answer'        => "Each tour page lists exactly what is included. Typically this covers guide services, transport, entrance fees, and any meals mentioned. Check the \"What's Included\" section on each tour for specifics.",
            ],
            [
                'category'      => 'Tour Experience',
                'category_icon' => 'fa-solid fa-compass',
                'category_sort' => 50,
                'sort_order'    => 2,
                'question'      => 'How large are the tour groups?',
                'answer'        => 'Most of our tours run with 2–15 people per group. Private tours are available for those who prefer a more exclusive experience.',
            ],
            [
                'category'      => 'Tour Experience',
                'category_icon' => 'fa-solid fa-compass',
                'category_sort' => 50,
                'sort_order'    => 3,
                'question'      => 'Are your tours suitable for children?',
                'answer'        => 'Many of our tours are family-friendly. Each tour page indicates the recommended minimum age and difficulty level. Contact us if you need advice on the best tour for your family.',
            ],
            [
                'category'      => 'Tour Experience',
                'category_icon' => 'fa-solid fa-compass',
                'category_sort' => 50,
                'sort_order'    => 4,
                'question'      => 'Do I need to be physically fit for hiking tours?',
                'answer'        => 'Fitness requirements vary by tour. Each tour has a difficulty rating (Easy, Moderate, Challenging). We recommend reading the tour description carefully and contacting us if you are unsure.',
            ],
            [
                'category'      => 'Tour Experience',
                'category_icon' => 'fa-solid fa-compass',
                'category_sort' => 50,
                'sort_order'    => 5,
                'question'      => 'Are meals included in the tours?',
                'answer'        => 'Some tours include meals (usually lunch or a traditional Albanian food experience). This is clearly stated on each tour page. For day tours, you may want to bring snacks and water.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create(array_merge($faq, ['is_active' => true]));
        }
    }
}
