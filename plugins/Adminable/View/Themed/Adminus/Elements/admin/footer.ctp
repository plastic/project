<script type="text/javascript">
	URL_BASE = "<?php echo FULL_BASE_URL . $this->Html->url('/admin/'); ?>";
	URL_BASE_SITE = "<?php echo FULL_BASE_URL . $this->Html->url('/'); ?>";
</script>

<?php
$jsList = array('admin');

if (isset($this->requestJs))
	$jsList[] = $this->requestJs;
	
echo $this->ScriptCombiner->js($jsList);
?>