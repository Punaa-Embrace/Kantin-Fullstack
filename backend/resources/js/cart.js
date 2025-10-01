document.addEventListener('alpine:init', () => {
    Alpine.store('cart', {
        items: [],

        init() {
            this.items = JSON.parse(localStorage.getItem('jaka_cart_items')) || [];

            Alpine.effect(() => {
                localStorage.setItem('jaka_cart_items', JSON.stringify(this.items));
            });
        },

        add(menuItem) {
            const existingItem = this.items.find(i => i.id === menuItem.id);

            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.items.push({ ...menuItem, quantity: 1, notes: '' });
            }
        },

        remove(itemId) {
            this.items = this.items.filter(i => i.id !== itemId);
        },
        
        updateQuantity(itemId, amount) {
            const item = this.items.find(i => i.id === itemId);
            if (item) {
                const newQuantity = item.quantity + amount;
                if (newQuantity < 1) {
                    this.remove(itemId);
                } else {
                    item.quantity = newQuantity;
                }
            }
        },
        
        updateNotes(itemId, newNotes) {
            const item = this.items.find(i => i.id === itemId);
            if (item) {
                item.notes = newNotes;
            }
        },

        getItemQuantity(itemId) {
            const item = this.items.find(i => i.id === itemId);
            return item ? item.quantity : 0;
        },

        clear() {
            this.items = [];
        },

        get totalItems() {
            if (!Array.isArray(this.items)) return 0;
            return this.items.reduce((sum, item) => sum + item.quantity, 0);
        },
        
        get subtotal() {
            if (!Array.isArray(this.items)) return 0;
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
    });
});

