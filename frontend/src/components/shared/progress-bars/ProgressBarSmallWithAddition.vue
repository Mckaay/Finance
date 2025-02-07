<script setup>
import { computed } from "vue";

const props = defineProps({
  amount: {
    type: Number,
    default: () => 0,
  },
  target: {
    type: Number,
    default: () => 0,
  },
  balance: {
    type: Number,
    default: () => 0,
  },
  type: {
    type: String,
    default: () => "deposit",
  },
});

const additionalBarColor = computed(() =>
  props.type === "deposit" ? "#277C78" : "#C94736",
);

const newBalance = computed(() => {
  const calculatedBalance =
    props.type === "deposit"
      ? props.balance + props.amount
      : Math.max(0, props.balance - props.amount);

  return `$${calculatedBalance.toFixed(2)}`;
});

const calculatePercentage = (value, total) => {
  if (total <= 0) return 0;
  return (value / total) * 100;
};

const basePercentage = computed(() =>
  calculatePercentage(props.balance, props.target),
);

const amountPercentage = computed(() =>
  calculatePercentage(props.amount, props.target),
);

const defaultBarPercentage = computed(() => {
  if (props.type === "deposit") return basePercentage.value;
  return Math.max(0, basePercentage.value - amountPercentage.value);
});

const additionalBarPercentage = computed(() => {
  if (props.type === "deposit") {
    return Math.min(100 - basePercentage.value, amountPercentage.value);
  }
  return Math.min(amountPercentage.value, basePercentage.value);
});

const formattedPercentage = (value) => `${Math.max(0, value).toFixed(2)}%`;

const defaultBarWidth = computed(() =>
  formattedPercentage(defaultBarPercentage.value),
);

const additionalBarWidth = computed(() =>
  formattedPercentage(additionalBarPercentage.value),
);

const displayedPercentage = computed(() =>
  formattedPercentage(additionalBarPercentage.value),
);
</script>

<template>
  <div class="wrapper">
    <div class="top-wrapper">
      <div class="description">
        New Amount
      </div>
      <div class="balance">
        {{ newBalance }}
      </div>
    </div>

    <div class="progress-bar">
      <div
        class="default-bar"
        :style="{ width: defaultBarWidth }"
      />
      <div
        class="additional-bar"
        :style="{
          width: additionalBarWidth,
          backgroundColor: additionalBarColor,
        }"
      />
    </div>

    <div class="bottom-wrapper">
      <div class="percentage">
        {{ displayedPercentage }}
      </div>
      <div class="bottom-text">
        Target of ${{ props.target.toFixed(2) }}
      </div>
    </div>
  </div>
</template>

<style scoped>
.wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-100);
  font-size: var(--fs-87);
  color: var(--clr-grey-500);
}

.top-wrapper {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.balance {
  color: var(--clr-grey-900);
  font-weight: var(--fw-700);
  font-size: var(--fs-200);
}

.bottom-wrapper {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.percentage {
  font-weight: var(--fw-700);
  color: v-bind("additionalBarColor");
}

.progress-bar {
  --progress-bar-height: var(--spacing-50);
  height: var(--progress-bar-height);
  display: flex;
  gap: 0.125rem;
  width: 100%;
  border-radius: var(--spacing-25);
  background-color: var(--clr-beige-100);
}

.progress-bar > * {
  height: inherit;
  border-radius: inherit;
}

.default-bar {
  background-color: var(--clr-grey-900);
  transition: width 0.3s ease;
}

.additional-bar {
  transition: width 0.3s ease;
}
</style>
