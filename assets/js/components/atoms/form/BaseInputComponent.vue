<template>
  <div class="form-auth__field">
    <input
      :placeholder="label"
      :value="modelValue"
      :name="name"
      @input="$emit('update:modelValue', $event.target.value)"
      v-bind="$attrs"
    />
  </div>
</template>

<script setup>

defineProps({
  label: {
    type: String,
    required: true,
  },
  modelValue: {
    type: String,
    default: '',
  },
  name: {
    type: String,
  },
});

</script>
