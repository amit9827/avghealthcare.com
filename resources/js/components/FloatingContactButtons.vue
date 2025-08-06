<template>
    <div>
      <!-- Call Now Button -->
      <a
        :href="'tel:' + phoneNumber"
        class="btn btn-danger position-fixed bottom-0 start-0 m-3 d-flex align-items-center gap-2"
        style="z-index: 1050; border-radius: 30px;"
      >
        <i class="fa fa-phone"></i> Call Now
      </a>

      <!-- WhatsApp Button -->
      <a
        :href="'https://wa.me/' + whatsappNumber"
        target="_blank"
        class="btn btn-success position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2"
        style="z-index: 1050; border-radius: 30px;"
      >
        <i class="fab fa-whatsapp"></i> Chat
      </a>
    </div>
  </template>

  <script>
  export default {
    name: 'FloatingContactButtons',
    props: {
      phoneNumber: {
        type: String,
        default: '918888888888', // Replace with your number
      },
      whatsappNumber: {
        type: String,
        default: '918888888888', // Replace with your number (country code + number)
      },
    },
  }
  </script>

  <style scoped>
  .btn {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }
  </style>
