<?php
class EnhanceOutputTemplateFactoryTestFixture {

	public function CreateOutputTemplateWithXmlExpectXmlTemplateTest() {
		$Output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Xml);

		Assert::AreIdentical(EnhanceOutputTemplateType::Xml, $Output->GetTemplateType());
	}	

	public function CreateOutputTemplateWithHtmlExpectHtmlTemplateTest() {
		$Output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Html);

		Assert::AreIdentical(EnhanceOutputTemplateType::Html, $Output->GetTemplateType());
	}	

	public function CreateOutputTemplateWithCliExpectCliTemplateTest() {
		$Output = EnhanceOutputTemplateFactory::CreateOutputTemplate(EnhanceOutputTemplateType::Cli);

		Assert::AreIdentical(EnhanceOutputTemplateType::Cli, $Output->GetTemplateType());
	}	
}
?>
