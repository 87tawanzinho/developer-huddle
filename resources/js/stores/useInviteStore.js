
import { defineStore } from 'pinia'

export const useInvitesStore = defineStore('invites', {
  state: () => ({
    isOpen: false, 
    invitations: []
  }),
})
