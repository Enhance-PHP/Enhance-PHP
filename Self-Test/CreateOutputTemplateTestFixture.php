<?php
class CreateOutputTemplateTestFixture {

	public function CreateOutputTemplateWithXmlExpectXmlTemplateTest() {
		$Output = MockFactory::CreateOutputTemplate('Xml');

		Assert::AreIdentical('Xml', $Output.TemplateType);
	}	
}
?>