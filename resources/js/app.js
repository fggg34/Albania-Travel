import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import flatpickr from 'flatpickr';
import TomSelect from 'tom-select';
import Swiper from 'swiper/bundle';
import 'flatpickr/dist/flatpickr.min.css';
import 'tom-select/dist/css/tom-select.css';
import 'swiper/css/bundle';

Alpine.plugin(collapse);
window.Alpine = Alpine;
window.flatpickr = flatpickr;
window.TomSelect = TomSelect;

Alpine.data('bookingSidebar', (config) => ({
  priceUrl: config.priceUrl,
  datesUrl: config.datesUrl,
  slug: config.slug,
  maxGuests: config.maxGuests,
  createUrl: config.createUrl,
  useCalendar: config.useCalendar,
  initialDate: config.initialDate || '',
  initialGuests: Math.max(1, Math.min(config.maxGuests, parseInt(config.initialGuests, 10) || 1)),
  guests: 1,
  selectedDate: '',
  pricePerPerson: config.basePrice || 0,
  total: (config.basePrice || 0) * 1,
  currency: (config.currency === 'EUR' || !config.currency ? '€' : config.currency),
  tierLabel: '',
  loading: true,
  participantsOpen: false,
  availableDates: [],
  closedDates: [],
  fp: null,
  async init() {
    this.guests = this.initialGuests;
    this.selectedDate = this.initialDate || '';
    if (!this.useCalendar) return;
    this.$nextTick(() => {
      this.initFlatpickr();
      if (this.initialDate && this.fp) this.fp.setDate(this.initialDate);
    });
    this.fetchDates().then(() => {
      if (this.fp) this.fp.set('disable', this.closedDates);
      if (this.initialDate && this.fp) this.fp.setDate(this.initialDate);
    });
    this.updatePrice();
    this.$watch('guests', () => this.updatePrice());
  },
  async fetchDates() {
    try {
      const from = new Date();
      const to = new Date();
      to.setMonth(to.getMonth() + 3);
      const url = `${this.datesUrl}?from=${from.toISOString().slice(0, 10)}&to=${to.toISOString().slice(0, 10)}`;
      const res = await fetch(url);
      if (!res.ok) throw new Error('Failed to load dates');
      const data = await res.json();
      const raw = Array.isArray(data.dates) ? data.dates : [];
      this.availableDates = raw
        .filter(d => d && (d.is_available === true || (d.available_spots != null && d.available_spots > 0)))
        .map(d => d.date_formatted || d.date || null)
        .filter(Boolean);
      this.closedDates = Array.isArray(data.closed_dates) ? data.closed_dates : [];
    } catch (e) {
      this.closedDates = [];
    }
    this.loading = false;
  },
  buildFallbackDates(days) {
    const out = [];
    const d = new Date();
    for (let i = 0; i < days; i++) {
      const copy = new Date(d);
      copy.setDate(copy.getDate() + i);
      out.push(copy.toISOString().slice(0, 10));
    }
    return out;
  },
  initFlatpickr() {
    if (!window.flatpickr || !this.$refs.dateInput || !this.$refs.calendarContainer) return;
    const self = this;
    const maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() + 1);
    this.fp = window.flatpickr(this.$refs.dateInput, {
      dateFormat: 'Y-m-d',
      minDate: 'today',
      maxDate: maxDate,
      disable: this.closedDates,
      static: true,
      appendTo: this.$refs.calendarContainer,
      onChange(selected, dateStr) {
        self.selectedDate = dateStr || '';
        self.updatePrice();
      },
    });
  },
  async updatePrice() {
    try {
      const res = await fetch(`${this.priceUrl}?guests=${this.guests}`);
      const data = await res.json();
      this.pricePerPerson = data.price_per_person ?? 0;
      this.total = data.total ?? 0;
      const apiCurrency = String(data.currency || '').toUpperCase();
      if (apiCurrency && apiCurrency !== 'EUR') {
        this.currency = data.currency;
      }
      // keep € for EUR - never overwrite with 'EUR' from API
      this.tierLabel = data.tier_applied ? 'Group discount applied' : '';
    } catch (e) {
      this.pricePerPerson = config.basePrice || 0;
      this.total = this.pricePerPerson * this.guests;
    }
  },
}));

Alpine.data('mobileBookingBar', () => ({
  visible: true,
  init() {
    const target = document.getElementById('booking-form');
    if (!target) return;
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((e) => { this.visible = !e.isIntersecting; });
      },
      { threshold: 0.1, rootMargin: '-60px 0px 0px 0px' }
    );
    observer.observe(target);
  },
  scrollToBooking() {
    document.getElementById('booking-form')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  },
}));

Alpine.data('searchSidebarDate', (initialDate = '') => ({
  fp: null,
  init() {
    this.$nextTick(() => this.initFlatpickr());
  },
  initFlatpickr() {
    if (!window.flatpickr || !this.$refs.dateInput) return;
    const maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() + 1);
    this.fp = window.flatpickr(this.$refs.dateInput, {
      dateFormat: 'Y-m-d',
      minDate: 'today',
      maxDate: maxDate,
      allowInput: false,
    });
    if (initialDate) this.fp.setDate(initialDate);
  },
}));

Alpine.data('heroSearchForm', (config) => ({
  action: config.action,
  cities: config.cities || [],
  initialCity: config.initialCity || '',
  initialDate: config.initialDate || '',
  initialAdults: Math.max(1, parseInt(config.initialAdults, 10) || 2),
  selectedCity: config.initialCity || '',
  selectedDate: config.initialDate || '',
  adults: Math.max(1, parseInt(config.initialAdults, 10) || 2),
  cityOpen: false,
  dateOpen: false,
  adultsOpen: false,
  fp: null,
  get selectedCityName() {
    if (!this.selectedCity) return '';
    const c = this.cities.find(x => x.slug === this.selectedCity);
    return c ? c.name : '';
  },
  init() {
    this.selectedCity = this.initialCity;
    this.selectedDate = this.initialDate;
    this.adults = this.initialAdults;
    this.$nextTick(() => this.initFlatpickr());
  },
  selectCity(slug) {
    this.selectedCity = slug || '';
  },
  toggleDatePicker() {
    if (!this.fp) return;
    if (this.dateOpen) {
      this.fp.close();
    } else {
      this.fp.open();
    }
  },
  formatDate(ymd) {
    if (!ymd) return '';
    const d = new Date(ymd + 'T00:00:00');
    return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
  },
  initFlatpickr() {
    if (!window.flatpickr || !this.$refs.dateInput || !this.$refs.dateContainer) return;
    const self = this;
    const maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() + 1);
    this.fp = window.flatpickr(this.$refs.dateInput, {
      dateFormat: 'Y-m-d',
      minDate: 'today',
      maxDate: maxDate,
      appendTo: this.$refs.dateContainer,
      static: true,
      onOpen() { self.dateOpen = true; },
      onClose() { self.dateOpen = false; },
      onChange(selected, dateStr) {
        self.selectedDate = dateStr || '';
      },
    });
    if (this.initialDate) this.fp.setDate(this.initialDate);
  },
  submitForm(e) {
    // Form submits naturally with hidden inputs
  },
}));

function homeSlider(config) {
  const fixedSlideBy = config?.fixedSlideBy;
  return {
    slideBy: fixedSlideBy ?? config?.slideBy ?? 1,
    fixedSlideBy: fixedSlideBy != null,
    init() {
      if (!this.fixedSlideBy) {
        this.$nextTick(() => this.updateSlideBy());
        window.addEventListener('resize', () => this.updateSlideBy());
      }
    },
    updateSlideBy() {
      if (this.fixedSlideBy) return;
      const el = this.$refs.track;
      if (!el) return;
      const cards = el.querySelectorAll('[data-slider-card]');
      if (cards.length === 0) return;
      const cardWidth = cards[0].offsetWidth;
      const container = el.querySelector('[data-slider-gap]');
      const gap = container ? parseInt(container.dataset.sliderGap || '20', 10) : 20;
      const containerWidth = el.parentElement?.offsetWidth ?? el.offsetWidth;
      const visibleCount = Math.floor((containerWidth + gap) / (cardWidth + gap));
      this.slideBy = Math.max(1, visibleCount);
    },
    scrollNext() {
      const el = this.$refs.track;
      if (!el) return;
      const cards = el.querySelectorAll('[data-slider-card]');
      if (cards.length === 0) return;
      const cardWidth = cards[0].offsetWidth;
      const container = el.querySelector('[data-slider-gap]');
      const gap = container ? parseInt(container.dataset.sliderGap || '20', 10) : 20;
      const scrollAmount = (cardWidth + gap) * this.slideBy;
      el.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    },
  };
}
Alpine.data('homeSlider', homeSlider);
window.homeSlider = homeSlider;

function swiperSlider(config = {}) {
  return {
    init() {
      this.$nextTick(() => {
        const el = this.$refs.swiperEl;
        if (!el) return;
        const opts = {
          grabCursor: true,
          allowTouchMove: true,
          simulateTouch: true,
          spaceBetween: config.spaceBetween ?? 16,
          slidesPerView: config.slidesPerView ?? 1,
          breakpoints: config.breakpoints,
          ...config,
        };
        opts.navigation = (config.navigation && this.$refs.prevBtn && this.$refs.nextBtn)
          ? { prevEl: this.$refs.prevBtn, nextEl: this.$refs.nextBtn }
          : false;
        opts.pagination = (config.pagination && this.$refs.paginationEl)
          ? { el: this.$refs.paginationEl, clickable: true }
          : false;
        new Swiper(el, opts);
      });
    },
  };
}
Alpine.data('swiperSlider', swiperSlider);

function gallerySwiperSlider(total, images) {
  return {
    total,
    images: Array.isArray(images) ? images : [],
    lightboxOpen: false,
    lightboxIndex: 0,
    init() {
      this.$nextTick(() => {
        const el = this.$refs.swiperEl;
        if (!el) return;
        const self = this;
        new Swiper(el, {
          grabCursor: true,
          allowTouchMove: true,
          simulateTouch: true,
          spaceBetween: 8,
          slidesPerView: 1,
          breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
          navigation: (this.$refs.prevBtn && this.$refs.nextBtn)
            ? { prevEl: this.$refs.prevBtn, nextEl: this.$refs.nextBtn }
            : false,
          on: {
            click(swiper, e) {
              const idx = swiper.clickedIndex;
              if (idx >= 0 && idx < self.images.length) self.openLightbox(idx);
            },
          },
        });
      });
    },
    openLightbox(index) {
      this.lightboxIndex = index;
      this.lightboxOpen = true;
      document.body.style.overflow = 'hidden';
    },
    closeLightbox() {
      this.lightboxOpen = false;
      document.body.style.overflow = '';
    },
    lightboxPrev() {
      this.lightboxIndex = this.lightboxIndex === 0 ? this.images.length - 1 : this.lightboxIndex - 1;
    },
    lightboxNext() {
      this.lightboxIndex = this.lightboxIndex === this.images.length - 1 ? 0 : this.lightboxIndex + 1;
    },
  };
}
Alpine.data('gallerySwiperSlider', gallerySwiperSlider);

Alpine.data('stickySidebar', () => ({
  fixed: false,
  width: 0,
  left: 0,
  topOffset: 30,
  placeholderHeight: 0,
  init() {
    if (window.matchMedia('(max-width: 1023px)').matches) return;
    this.update();
    window.addEventListener('scroll', () => this.update(), { passive: true });
    window.addEventListener('resize', () => {
      this.fixed = false;
      requestAnimationFrame(() => this.update());
    });
  },
  update() {
    const wrap = this.$refs.stickyWrap;
    if (!wrap) return;
    if (this.fixed) {
      const placeholder = this.$refs.placeholder;
      if (placeholder) {
        const phRect = placeholder.getBoundingClientRect();
        if (phRect.top >= this.topOffset) {
          this.fixed = false;
        } else {
          const rect = wrap.getBoundingClientRect();
          this.width = rect.width;
          this.left = rect.left;
        }
      }
      return;
    }
    const rect = wrap.getBoundingClientRect();
    if (rect.top <= this.topOffset) {
      this.placeholderHeight = wrap.offsetHeight;
      this.width = rect.width;
      this.left = rect.left;
      this.fixed = true;
    }
  },
}));

Alpine.start();
