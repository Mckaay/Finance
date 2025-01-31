<script setup>
import {computed} from "vue";

const props = defineProps({
  amount: {
    type: Number,
    default: 0,
  },
  target: {
    type: String,
    default: "0",
  },
  balance: {
    type: Number,
    default: 0,
  },
  type: {
    type: String,
    default: "deposit",
  }
})

const color = computed(() => {
  return props.type === 'deposit' ? '#277C78' : '#C94736';
});

const defaultBarWidth = computed(() => {
  return `${calculateDefaultBarWidth(props.balance, props.target)}%`;
})

const calculateDefaultBarWidth = (balance, target) => {
  const fill = (balance / target) * 100;
  if (fill <= 0) {
    return 0;
  }

  return fill.toFixed(2);
}

const additionalBarWidth = computed(() => {
  return `${calculateAdditionalBarWidth(props.amount, props.target)}%`;
})
const calculateAdditionalBarWidth = (amount, target) => {
  if (calculateDefaultBarWidth.value >= 100) {
    return 0;
  }

  const fill = (amount / target) * 100;
  if (fill <= 0) {
    return 0;
  }

  return fill.toFixed(2);
}
</script>

<template>
  <div class="wrapper">
    <div class="top-wrapper">
      <div class="description">
        New Amount
      </div>
      <div class="amount">
        ${{ (props.balance + props.amount).toFixed(2) }}
      </div>
    </div>
    <div class="progress-bar">
      <div class="default-bar"></div>
      <div class="additional-bar"></div>
    </div>
    <div class="bottom-wrapper">
      <div class="percentage">
        {{ (parseFloat(additionalBarWidth) + parseFloat(defaultBarWidth)).toFixed(2) }}%
      </div>
      <div class="bottom-text">
        Target of ${{ props.target }}
      </div>    </div>
  </div>
</template>

<style scoped>
.wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-100);
  font-size: var(--fs-87);
  color: var(--clr-grey-500);

  & .top-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;

    & .amount {
      color: var(--clr-grey-900);
      font-weight: var(--fw-700);
      font-size: var(--fs-200);
    }
  }

  & .bottom-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  & .percentage {
    font-weight: var(--fw-700);
    color: v-bind('color');
  }
}

.progress-bar {
  --progress-bar-height: var(--spacing-50);
  border-radius: var(--spacing-25);
  background-color: var(--clr-beige-100);
  height: var(--progress-bar-height);
  display: flex;
  gap: 0.125rem;
  width: 100%;
}

.progress-bar > * {
  height: inherit;
  border-radius: inherit;
}

.default-bar {
  background-color: var(--clr-grey-900);
  width: v-bind('defaultBarWidth');
}

.additional-bar {
  background-color: v-bind('color');
  margin-left: 2px;
  width: v-bind('additionalBarWidth');
}
</style>