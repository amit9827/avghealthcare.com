<template>
    <div class="review-container mb-3" v-if="customer_reviews && customer_reviews.length">
      <!-- Title -->
      <h2 class="review-title text-center mb-3">Our Happy Customers</h2>

      <div class="row">
        <div class="col-md-6">
          <!-- Rating Summary -->
          <div class="rating-summary text-center">
            <div class="stars mb-2">
              <i
                v-for="n in 5"
                :key="n"
                class="fas fa-star"
                :class="n <= Math.round(averageRating) ? 'color-custom-orange' : 'text-muted'"
              ></i>
            </div>
            <div class="rating-text mb-3">
              {{ averageRating.toFixed(2) }} out of 5 |
              {{ customer_reviews.length }} Customer Ratings
            </div>

            <!-- Write Review Button -->
            <div class="text-center">
              <button class="btn text-white font-bold bg-custom-orange-dark mb-5"     @click="handleWriteReview"
>
                Write A Review
              </button>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <!-- Rating Breakdown -->
          <div class="rating-breakdown ps-3">
            <div
              v-for="(percent, index) in ratingPercentages"
              :key="index"
              class="rating-row row align-items-center"
            >
              <div class="col-md-2 col-3 rating-label">{{ 5 - index }} Stars</div>
              <div class="col-md-7 col-6 progress-wrapper">
                <div class="progress">
                  <div
                    class="progress-bar bg-custom-orange-dark"
                    :style="{ width: percent + '%' }"
                  ></div>
                </div>
              </div>
              <div class="col-3 percentage">{{ percent.toFixed(0) }}%</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Review Cards -->
      <div
        v-for="(review, index) in customer_reviews"
        :key="review.id"
        class="review-card"

      >
        <div class="review-divider"></div>

        <div class="row g-4">
          <!-- Left Column - Review Content -->
          <div class="col-12 col-md-8 col-lg-9">
            <div class="d-flex flex-column gap-2 gap-md-3">
              <div class="star-rating">
                <i
                  v-for="n in 5"
                  :key="n"
                  class="fas fa-star"
                  :class="n <= review.star_rating ? 'color-custom-orange' : 'text-muted'"
                ></i>
              </div>

              <p class="review-text">{{ review.message }}</p>
            </div>
          </div>

          <!-- Right Column - Meta Information -->
          <div class="col-12 col-md-4 col-lg-3">
            <div class="d-flex flex-column justify-content-between h-100 gap-2">
              <div class="d-flex flex-column gap-1">
                <p class="review-meta mb-0">Submitted {{ formatDate(review.review_date) }}</p>
                <p class="review-meta mb-0">By {{ review.name }}</p>
                <div v-if="review.verified_buyer" class="verified-badge">
                <img
                  :src="getassetpath('verified.svg')"
                  alt="Verified"
                  class="verified-icon"
                />
                <p class="verified-text">VERIFIED BUYER</p>
              </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="text-center py-4 text-muted">
      No reviews yet for this product.
    </div>

    <!-- Custom Popup Modal -->
<div v-if="showModal" class="popup-overlay">
  <div class="popup-content">
    <p>You must be a registered buyer to write a review</p>
    <button @click="showModal = false" class="btn btn-sm bg-custom-orange-dark text-white">
      OK
    </button>
  </div>
</div>



  </template>

  <script>
  export default {
    name: "ProductReviews",
    props: {
      customer_reviews: {
        type: Array,
        default: () => [],
      },
      product: {
        type: Object,
        default: () => ({}),
      },
    },
    computed: {
      averageRating() {
        if (!this.customer_reviews.length) return 0;
        const total = this.customer_reviews.reduce(
          (sum, r) => sum + Number(r.star_rating || 0),
          0
        );
        return total / this.customer_reviews.length;
      },
      ratingPercentages() {
        const total = this.customer_reviews.length || 1;
        const counts = [0, 0, 0, 0, 0];
        this.customer_reviews.forEach((r) => {
          const rating = parseInt(r.star_rating);
          if (rating >= 1 && rating <= 5) counts[5 - rating]++;
        });
        return counts.map((c) => (c / total) * 100);
      },
    },
    methods: {
      formatDate(date) {
        if (!date) return "";
        const d = new Date(date);
        return d.toLocaleDateString("en-IN", {
          day: "numeric",
          month: "short",
          year: "numeric",
        });
      },

      getassetpath(product_path) {
      return `..\\assets\\${product_path}`;
    },

    handleWriteReview() {
    // Simple browser alert
    //alert("You must be a registered buyer to write a review");

    // or, if you want a custom modal later, you can replace this with:
     this.showModal = true;
  },


    },
    data() {
      return {
        colors: [
          "rgb(203, 237, 243)",
          "rgb(255, 230, 230)",
          "rgb(230, 255, 230)",
          "rgb(255, 245, 204)",
          "rgb(230, 230, 255)",
          "rgb(255, 240, 245)",
        ],

        showModal: false,


      };
    },
  };
  </script>

  <style scoped>
  .review-card {
    border-radius: 12px;
    padding: 10px;
    margin:  0;
  }
  .review-divider {
    height: 0.5px;
    background-color: #343a40;
    width: 100%;
    margin-bottom: 16px;
  }
  .star-rating {
    display: flex;
    gap: 2px;
    margin-bottom: 0px;
  }
  .review-text {
    color: #212529;
    font-size: 14px;
    line-height: 1.4;
  }
  .review-meta {
    color: #212529;
    font-size: 13px;
  }
  .verified-badge {
    display: flex;
    align-items: center;
    gap: 4px;
  }
  .verified-icon {
    width: 20px;
    height: 20px;
  }
  .verified-text {
    color: #212529;
    font-size: 12px;
    margin:0px;

  }
  .color-custom-orange {
    color: #ffbb38;
  }
  .bg-custom-orange-dark {
    background-color: #ed7f30;
  }
  .text-muted {
    color: #ccc;
  }


  .popup-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex; justify-content: center; align-items: center;
  z-index: 9999;
}

.popup-content {
  background: #fff;
  padding: 20px 30px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}



  </style>
