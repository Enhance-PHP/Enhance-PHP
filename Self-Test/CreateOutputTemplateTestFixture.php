<?php
class CreateOutputTemplateTestFixture {

    public function CreateOutputTemplateWithXmlExpectXmlTemplateTest() {
        $Output = MockFactory::CreateOutputTemplate('Xml');

        Assert::areIdentical('Xml', $Output.TemplateType);
    }    
}
?>