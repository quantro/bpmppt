<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Biupload
 * @category    Libraries
 */

// -----------------------------------------------------------------------------

class Biupload
{
    /**
     * Codeigniter superobject
     * @var  mixed
     */
    protected $_ci;

    /**
     * Maximum upload files limit
     * @var  int
     */
    protected $max_upload_files = 5;

    /**
     * Nama field yang dipakai untuk upload.
     * Default menggunakan nama bawaan CI
     * @var  string
     */
    protected $field_name = 'userfile';

    /**
     * Configuration
     * @var  string
     */
    protected $configs = array(
        'allowed_types'   => '',
        'auto_thumbnail'  => FALSE,
        'upload_endpoint' => '',
        );

    /**
     * Default class constructor
     */
    public function __construct( array $configs = array() )
    {
        $this->_ci =& get_instance();

        $this->_ci->load->library('upload');
        $this->_ci->config->load('biupload');
        $this->_ci->lang->load('biupload');

        if ( !empty( $configs ) )
        {
            $this->initialize( $configs );
        }

        log_message('debug', "#BootIgniter: Biupload Class Initialized");
    }

    /**
     * Initialize method
     *
     * @param   array   $configs  Configuration Overwrite
     * @return  void
     */
    public function initialize( $configs )
    {
        foreach ($configs as $key => $val)
        {
            if (isset($this->configs[$key]))
            {
                $this->configs[$key] = $val;
            }
        }

        $this->_ci->upload->initialize( array(
            'upload_path' => APPPATH.'storage/upload/',
            'allowed_types' => $this->configs['allowed_types'],
            ));
        $this->_scripts();

        return $this;
    }

    /**
     * Get the HTML format that will be shown in Former library.
     *
     * @param   string  $identifier  File identifier
     * @return  string
     */
    public function get_html( $identifier )
    {
        $attr  = 'data-allowed-ext="'.implode( '|', $this->_ci->upload->allowed_types ).'" ';
        $attr .= 'data-item-limit="'.$this->max_upload_files.'" ';
        $attr .= 'data-size-limit="'.$this->_ci->upload->max_size.'" ';
        $attr .= 'data-field-name="'.$identifier.'" ';

        return '<div class="fine-uploader row" '.$attr.'></div>';
    }

    protected function _scripts()
    {
        $upload_path = str_replace(FCPATH, '', $this->_ci->upload->upload_path);
        // Uploader trigger
        $script = "$('.fine-uploader').each(function() {\n"
                . "    var fu = $(this),\n"
                . "        fuLimit = fu.data('item-limit'),\n"
                . "        fuTypes = fu.data('allowed-ext')\n"
                . "        fuField = fu.data('field-name')\n\n"
                . "    fu.fineUploader({\n"
                . "        template: 'qq-template',\n"
                . "        request: {\n"
                . "            endpoint: '".config_item('biupload_endpoint')."?limit='+fuLimit+'&types='+fuTypes,\n"
                . "            inputName: '".$this->field_name."'\n"
                . "        },\n"
                . "        validation: {\n"
                . "            allowedExtensions: fuTypes.split('|'),\n"
                . "            itemLimit: fuLimit,\n"
                . "            sizeLimit: fu.data('size-limit')\n"
                . "        },\n"
                . "        retry: {\n"
                . "            autoRetryNote: '"._x('biupload_text_auto_retry_note')."',\n"
                . "            enableAuto: true,\n"
                . "            showButton: true,\n"
                . "            maxAutoAttempts: 1\n"
                . "        },\n"
                . "        text: {\n"
                . "            failUpload: '"._x('biupload_text_fail_upload')."',\n"
                . "            formatProgress: '"._x('biupload_text_format_progress')."',\n"
                . "            paused: '"._x('biupload_text_paused')."',\n"
                . "            waitingForResponse: '"._x('biupload_text_waiting_response')."',\n"
                . "        },\n"
                . "        messages: {\n"
                . "            emptyError: '"._x('biupload_error_empty')."',\n"
                . "            maxHeightImageError: '"._x('biupload_error_max_height_image')."',\n"
                . "            maxWidthImageError: '"._x('biupload_error_max_width_image')."',\n"
                . "            minHeightImageError: '"._x('biupload_error_min_height_image')."',\n"
                . "            minWidthImageError: '"._x('biupload_error_min_width_image')."',\n"
                . "            minSizeError: '"._x('biupload_error_min_size')."',\n"
                . "            noFilesError: '"._x('biupload_error_no_files')."',\n"
                . "            onLeave: '"._x('biupload_error_on_leave')."',\n"
                . "            retryFailTooManyItemsError: '"._x('biupload_error_retry_fail_too_many_items')."',\n"
                . "            sizeError: '"._x('biupload_error_size')."',\n"
                . "            tooManyItemsError: '"._x('biupload_error_too_many_items')."',\n"
                . "            typeError: '"._x('biupload_error_type')."'\n"
                . "        }\n"
                . "    }).on('error', function (event, id, name, reason) {\n"
                . "        var selector = $('[qq-file-id='+id+']').find('.qq-upload-status-text-selector');\n"
                // . "        var selector = $('.qq-upload-status-text-selector');\n"
                . "        selector.append(reason.toString())\n"
                // . "        console.log(name);\n"
                // . "        console.log(reason);\n"
                . "    }).on('complete', function (event, id, name, response) {\n"
                . "        console.log(response);\n"
                . "        var uploadId = $('[qq-file-id='+id+']')\n\n"
                . "        if (response.success === true) {"
                . "            var uploadedFile = '<input type=\"hidden\" name=\"'+fuField+'[]\" value=\"'+response.data.file_name+'\" />'\n"
                . "            var fileDetail = '<dl class=\"upload-desc\">'\n"
                . "                           + '<dt>"._x('biupload_client_name')."</dt><dd>'+response.data.client_name+'</dd>'\n"
                . "                           + '<dt>"._x('biupload_file_name')."</dt><dd>'+response.data.file_name+'</dd>'\n"
                . "                           + '<dt>"._x('biupload_file_size')."</dt><dd>'+response.data.file_size+'</dd>'\n"
                . "                           + '<dt>"._x('biupload_file_type')."</dt><dd>'+response.data.file_type+'</dd>'\n"
                . "                           + '<dt>"._x('biupload_file_path')."</dt><dd>".$upload_path."</dd>'\n"
                . "                           + '</dl>';\n"
                . "            if(response.data.image_thumbnail !== undefined) {\n"
                . "                uploadId.find('.panel-body').append('<img src=\"".base_url($upload_path)."/'+response.data.image_thumbnail+'\" alt=\"'+response.data.client_name+'\" class=\"upload-file upload-preview img img-responsive\">')\n"
                . "            } else {\n"
                . "                uploadId.find('.panel-body').append('<span class=\"upload-file upload-icon fa fa-file\"><span class=\"upload-ext\">'+response.data.file_ext+'</span>')\n"
                . "            }\n"
                . "            uploadId.append(uploadedFile)\n"
                . "            uploadId.find('.qq-upload-file-selector').attr('href', '#collapse'+id)\n"
                . "            uploadId.find('.panel-body').append(fileDetail)\n"
                . "            uploadId.children('.panel-collapse').attr('id', 'collapse'+id)\n"
                . "        } else {\n"
                . "            uploadId.find('.qq-upload-status-text-selector').html(response.message)\n"
                . "        }\n"
                . "    });\n"
                . "});";

        // Load the JS
        // load_script('jq-fineuploader', 'js/lib/jquery.fineuploader.min.js', 'bootstrap', '5.0.3');
        // load_style('fineuploader');
        load_script('jq-fineuploader-trigger', $script, Bootigniter::VERSION, 'jq-fineuploader');
    }

    /**
     * Uploader template.
     * Default FineUploader template
     *
     * @return  string
     */
    public function template()
    {
        // Default qq-template
        $out = '<script type="text/template" id="qq-template">'
             . $this->_ci->load->view('upload', array(), TRUE)
             . '</script>';

        return $out;
    }

    /**
     * Let your user know your upload configurations
     *
     * @return  [type]
     */
    public function upload_policy()
    {
        $out = _x( 'biupload_upload_max_file', $this->max_upload_files );

        if ( ($_c_types = count(( $_types = $this->_ci->upload->allowed_types ))) > 0 )
        {
            $_file_types = '';

            for ($i = 0; $i < $_c_types; $i++)
            {
                $_file_types .= '<i class="bold">.'.strtoupper($_types[$i]).'</i>';
                $_file_types .= ($i == ($_c_types-2) ? ' dan ' : '; ');
            }

            $out .= ' dan '._x( 'biupload_upload_file_type', $_file_types );
        }

        return $out;
    }

    /**
     * Let's do the job
     *
     * @return  bool|array  Will return FALSE if got error.
     *                      Will return Array of file data.
     */
    public function do_upload()
    {
        if ( $this->_ci->upload->do_upload( $this->field_name ) )
        {
            $uploaded_data = $this->_ci->upload->data();

            if ( $this->configs['auto_thumbnail'] and $uploaded_data['is_image'] )
            {
                $uploaded_thumb = 'thumbs'.DS.$uploaded_data['file_name'];
                $this->_ci->load->library( 'image_lib', array(
                    'source_image'  => $uploaded_data['full_path'],
                    'new_image'     => $uploaded_data['file_path'].$uploaded_thumb,
                    'width'         => config_item('biupload_thumb_width'),
                    'height'        => config_item('biupload_thumb_height'),
                    ));

                if ( $this->_ci->image_lib->resize() )
                {
                    $uploaded_data['image_thumbnail'] = $uploaded_thumb;
                    log_message( 'debug', '#BootIgniter: Biupload->do_upload file "'.$uploaded_data['orig_name'].'" has been resized.' );
                }
                else
                {
                    $error_message = $this->image_lib->display_errors('', '');
                    log_message( 'debug', '#BootIgniter: Biupload->do_upload failed due to this error(s): '.$error_message.'.' );
                    set_message( 'error', $error_message );
                    return FALSE;
                }
            }

            log_message( 'debug', '#BootIgniter: Biupload->do_upload file "'.$uploaded_data['orig_name'].'" uploaded successfuly.' );
            return $uploaded_data;
        }
        else
        {
            // Grab the error(s)
            $error_message = $this->_ci->upload->display_errors('', '');
            log_message( 'debug', '#BootIgniter: Biupload->do_upload failed due to this error(s): '.$error_message.'.' );
            set_message( 'error', $error_message );
            return FALSE;
        }
    }
}

/* End of file Biupload.php */
/* Location: ./bootigniter/libraries/Biupload.php */
