Ext.ns('TYPO3.Workspaces.extension.AdditionalColumn');

TYPO3.Workspaces.extension.AdditionalColumn.WorkspacesLogger_StageChange = {
	id: 'WorkspaceLogger_StageChange',
	dataIndex : 'WorkspaceLogger_StageChange',
	width: 120,
	sortable: true,
	header: 'Stage Change',
	renderer: function(value, metaData, record, rowIndex, colIndex, store) {
		var date;
		if (record.json.WorkspacesLogger_StageChange) {
			date = new Date(record.json.WorkspacesLogger_StageChange * 1000);
			return Ext.util.Format.date(date, 'd-m-Y H:i');
		}
	},
	hidden: false
};