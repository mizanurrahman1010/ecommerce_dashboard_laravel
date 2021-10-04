<?php 
    namespace App\Constraints;

    class SkuGenerator2000
    {
            public function generate($productId, array $variants, array $disallow)
            {
                $permutations = $this->permutate($variants);
                $filtered     = $this->squelch($permutations, $disallow);
                $skus         = $this->skuify($productId, $filtered);
                return $skus;
            }
            public function permutate(array $variants)
            {
                $input  = array_filter($variants);
                $result = array(array());
                foreach ($input as $key => $values) {
                    $append = array();
                    foreach($result as $product) {
                        foreach($values as $item) {
                            $product[$key] = $item;
                            $append[] = $product;
                        }
                    }
                    $result = $append;
                }

                return $result;
            }
            public function squelch(array $permutations, array $rules)
            {
                foreach ($permutations as $per => $values) {
                    $valid = true;
                    $test  = array();
                    foreach ($values as $id => $val) {
                        $test[$id] = $val[0];
                    }
                    foreach ($rules as $rule) {
                        if (count(array_diff($rule, $test)) <= 0) {
                            $valid = false;
                        }
                    }
                    if (!$valid) {
                        unset($permutations[$per]);
                    }
                }
                return $permutations;
            }
            public function skuify($productId, array $variants)
            {
                $skus = array();
                foreach ($variants as $variant) {
                    $ids = array();
                    foreach ($variant as $vals) {
                        $ids[] = $vals[0];
                    }
                    $skus[$productId . '-' . implode('-', $ids)] = $variant;
                }
                return $skus;
            }
    }

?>