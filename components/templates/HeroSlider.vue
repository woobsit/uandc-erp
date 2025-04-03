<template>
  <v-container fluid class="pa-0 hero-slider-container">
    
    <v-carousel
      v-model="currentSlide"
      :continuous="true"
      :cycle="autoRotate"
      :show-arrows="showArrows"
      :hide-delimiters="hideIndicators"
      :height="sliderHeight"
      interval="6000"
      @mouseenter="pauseRotation"
      @mouseleave="resumeRotation"
    >
      <v-carousel-item
        v-for="(slide, index) in slides"
        :key="index"
        :src="slide.image"
        cover
      >
        <v-sheet
          :color="slide.overlayColor || 'rgba(0, 0, 0, 0.3)'"
          height="100%"
          class="d-flex align-center justify-center"
        >
          <v-container>
            <v-row class="text-center">
              <v-col cols="12" :class="textAlignment">
                <h1
                  class="text-h3 text-md-h2 text-lg-h1 font-weight-bold mb-4"
                  :class="slide.titleColor || 'white--text'"
                >
                  {{ slide.title }}
                </h1>
                <p
                  class="text-h6 text-md-h5 mb-6"
                  :class="slide.subtitleColor || 'white--text'"
                >
                  {{ slide.subtitle }}
                </p>
                <v-btn
                  v-if="slide.buttonText"
                  :color="slide.buttonColor || 'primary'"
                  size="large"
                  rounded
                  @click="handleButtonClick(slide)"
                >
                  {{ slide.buttonText }}
                  <v-icon end>mdi-arrow-right</v-icon>
                </v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-sheet>
      </v-carousel-item>
    </v-carousel>
  </v-container>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';

// Props
const props = defineProps({
  slides: {
    type: Array as () => HeroSlide[],
    required: false,
    default: () => [
      {
        image: 'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
        title: 'Premium Logistics Services',
        subtitle: 'Reliable shipping solutions worldwide',
        buttonText: 'Get a Quote',
        buttonColor: 'primary',
        buttonLink: '/contact'
      },
      {
        image: 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
        title: 'Fast & Secure Delivery',
        subtitle: 'Your goods in safe hands',
        titleColor: 'white--text',
        subtitleColor: 'white--text',
        buttonText: 'Track Shipment',
        buttonColor: 'secondary',
        buttonLink: '/tracking'
      },
      {
        image: 'https://images.unsplash.com/photo-1520333789090-1afc82db536a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80',
        title: 'Warehousing Solutions',
        subtitle: 'State-of-the-art storage facilities',
        buttonText: 'View Facilities',
        buttonColor: 'accent',
        buttonLink: '/warehousing'
      }
    ]
  },
  autoRotate: {
    type: Boolean,
    default: true
  },
  showArrows: {
    type: Boolean,
    default: true
  },
  hideIndicators: {
    type: Boolean,
    default: false
  },
  sliderHeight: {
    type: String,
    default: '600px'
  },
  textAlign: {
    type: String as () => 'left' | 'center' | 'right',
    default: 'center'
  }
})

// Types
interface HeroSlide {
  image: string
  title: string
  subtitle?: string
  titleColor?: string
  subtitleColor?: string
  overlayColor?: string
  buttonText?: string
  buttonColor?: string
  buttonLink?: string
  buttonAction?: () => void
}

// State
const currentSlide = ref(0)

// Computed
const textAlignment = computed(() => {
  return {
    'left': 'text-left',
    'center': 'text-center',
    'right': 'text-right'
  }[props.textAlign]
})

// Methods
const pauseRotation = () => {
  if (props.autoRotate) {
    // Pause logic would go here
  }
}

const resumeRotation = () => {
  if (props.autoRotate) {
    // Resume logic would go here
  }
}

const handleButtonClick = (slide: HeroSlide) => {
  if (slide.buttonAction) {
    slide.buttonAction()
  } else if (slide.buttonLink) {
    navigateTo(slide.buttonLink)
  }
}
</script>

<style scoped>
.hero-slider-container {
  max-width: 100%;
}

/* Custom overlay gradient */
.v-sheet {
  background: linear-gradient(
    to bottom,
    rgba(0, 0, 0, 0.2) 0%,
    rgba(0, 0, 0, 0.5) 100%
  ) !important;
}

/* Responsive text sizing */
@media (max-width: 600px) {
  .hero-slider-container :deep(.v-carousel) {
    height: 400px !important;
  }
  
  .hero-slider-container :deep(.text-h3) {
    font-size: 1.5rem !important;
  }
  
  .hero-slider-container :deep(.text-h6) {
    font-size: 1rem !important;
  }
}
</style>