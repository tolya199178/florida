        <?php

             foreach ($listBusiness as $objBusiness)
             {
                 $this->renderPartial('result_business_entity', array('data' => $objBusiness));
             }

        ?>