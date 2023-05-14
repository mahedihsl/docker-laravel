<template>
  <div class="tw-w-full tw-flex tw-flex-col">
    <div class="tw-flex tw-flex-row tw-justify-between tw-items-center">
      <h4>RMS Site Manager</h4>
      <button class="btn btn-sm btn-success" @click="$emit('create')">
        <i class="fa fa-plus"></i>
        New Site
      </button>
    </div>

    <table class="tw-w-full tw-mt-5">
      <thead>
        <tr>
          <th class="tw-w-3/12 tw-bg-blue-400 tw-px-4 tw-py-2 tw-text-white">
            Site name
          </th>
          <th class="tw-w-6/12 tw-bg-blue-400 tw-px-4 tw-py-2 tw-text-white">
            Installed devices
          </th>
          <th class="tw-w-3/12 tw-bg-blue-400 tw-px-4 tw-py-2 tw-text-white">
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="site in sites" :key="site.id">
          <td class="tw-w-3/12 tw-py-2">{{ site.name }}</td>
          <td class="tw-w-5/12 tw-py-2">
            <div class="tw-flex tw-flex-row tw-gap-2">
              <span
                v-for="device in site.com_ids"
                :key="device"
                class="
                  tw-bg-gray-200
                  tw-text-base
                  tw-text-gray-700
                  tw-font-semibold
                  tw-px-3
                  tw-py-1
                  tw-rounded
                "
              >
                {{ device }}
              </span>
            </div>
          </td>
          <td class="tw-w-4/12 tw-py-2">
            <div class="tw-flex tw-flex-row tw-justify-start tw-gap-2">
              <button
                class="btn btn-sm btn-default"
                @click="$emit('edit', site)"
              >
                <i class="fa fa-pencil"></i>
                Edit
              </button>
              <button
                class="btn btn-sm btn-primary"
                @click="$emit('configure', site)"
              >
                <i class="fa fa-cog"></i>
                Configure
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters('rms', ['sites']),
  },
}
</script>

<style lang="scss" scoped>
</style>