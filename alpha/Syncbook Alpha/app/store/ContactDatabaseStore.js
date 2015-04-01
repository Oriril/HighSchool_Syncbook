/*
 * File: app/store/ContactDatabaseStore.js
 *
 * This file was generated by Sencha Architect version 3.0.4.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 4.2.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 4.2.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('syncbook.store.ContactDatabaseStore', {
    extend: 'Ext.data.Store',

    requires: [
        'syncbook.model.ContactInformationModel',
        'Ext.data.proxy.Rest',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            autoLoad: false,
            autoSync: true,
            model: 'syncbook.model.ContactInformationModel',
            storeId: 'ContactDatabaseStore',
            proxy: {
                type: 'rest',
                idParam: 'ID',
                url: 'resources/libraries/syncbookServices/contactService.php/contacts',
                reader: {
                    type: 'json',
                    root: 'contacts'
                }
            }
        }, cfg)]);
    }
});