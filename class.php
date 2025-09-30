<?php
class Customer
{
    private $file = "customers.txt"; // yeh wo file hay jahan data save hoga yahan say retrive hoga
   
    // Create
    public function create($name, $email, $phone) // yeh create function banaya hay yahan say aik customer create hoga
    {
        if (empty($name) || empty($email) || empty($phone)) {
            return;
        }

        // Generate ID
        $newId = 1; // default id
        $customers = $this->read();
        if (!empty($customers)) {
            $lastCustomer = end($customers); // last record
            $newId = $lastCustomer["id"] + 1; // last id + 1
        }

        $fp = fopen($this->file, "a");
        $line = $newId . "|" . $name . "|" . $email . "|" . $phone . "\n";
        fwrite($fp, $line);
        fclose($fp);
    }


    // Read
    public function read()
    {
        $rows = [];

        if (file_exists($this->file)) {
            $fp = fopen($this->file, "r");
            while (($line = fgets($fp)) !== false) {
                $data = explode("|", trim($line)); // trim extra \n remove karega
                if (count($data) == 4) {
                    $rows[] = [
                        "id"    => $data[0],
                        "name"  => $data[1],
                        "email" => $data[2],
                        "phone" => $data[3]
                    ];
                }
            }
            fclose($fp);
           
        }

        return $rows;
    }

    // Update 
    public function update($id, $newName, $newEmail, $newPhone)
    {
        $customers = $this->read();
        $fp = fopen($this->file, "w"); // overwrite file

        foreach ($customers as $c) {
            if ($c["id"] == $id) {
                $line = $id . "|" . $newName . "|" . $newEmail . "|" . $newPhone . "\n";
            } else {
                $line = $c["id"] . "|" . $c["name"] . "|" . $c["email"] . "|" . $c["phone"] . "\n";
            }
            fwrite($fp, $line);
        }

        fclose($fp);
    }

    // Delete
    public function delete($id)
    {
        $customers = $this->read();
        $fp = fopen($this->file, "w");

        foreach ($customers as $c) {
            if ($c["id"] != $id) {
                $line = $c["id"] . "|" . $c["name"] . "|" . $c["email"] . "|" . $c["phone"] . "\n";
                fwrite($fp, $line);
            }
        }

        fclose($fp);
    }
}
